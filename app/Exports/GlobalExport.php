<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class GlobalExport implements FromCollection, WithHeadings
{
    protected string $modelClass;
    protected $user;
    protected array $ownershipCandidates = [
        'created_by', 'user_id', 'member_id', 'source_id', 'owner_id', 'added_by'
    ];
    protected array $hiddenColumns = ['password', 'remember_token', 'api_token'];
    protected ?string $forcedOwnershipColumn = null;

    public function __construct(string $modelClass, $user, array $options = [])
    {
        $this->modelClass = $modelClass;
        $this->user = $user;

        if (!empty($options['hidden'])) {
            $this->hiddenColumns = array_unique(array_merge($this->hiddenColumns, $options['hidden']));
        }

        if (!empty($options['ownership_column'])) {
            $this->forcedOwnershipColumn = $options['ownership_column'];
        }
    }

    public function collection()
    {
        $model = new $this->modelClass;
        $query = $model->newQuery();

        // Determine connection and table
        $connection = $model->getConnectionName() ?? 'mysql';
        $table = $model->getTable();

        // Get all table columns using correct DB connection
        $tableColumns = Schema::connection($connection)->getColumnListing($table);

        // Detect ownership column
        $columnToFilter = $this->forcedOwnershipColumn;
        if (!$columnToFilter) {
            $columnToFilter = collect($this->ownershipCandidates)
                ->first(fn($col) => in_array($col, $tableColumns));
        }

        // Filter for non-admin users
        if (!$this->isAdmin($this->user) && $columnToFilter) {
            $query->where($columnToFilter, $this->user->id);
        }

        // Fetch all records
        $rows = $query->get();

        // Hide sensitive columns
        if (!empty($this->hiddenColumns)) {
            $rows->makeHidden($this->hiddenColumns);
        }

        return $rows;
    }

    public function headings(): array
    {
        $model = new $this->modelClass;

        // Use same DB connection for column listing
        $connection = $model->getConnectionName() ?? 'mysql';
        $table = $model->getTable();

        $columns = Schema::connection($connection)->getColumnListing($table);

        // Remove hidden columns
        $columns = array_values(array_diff($columns, $this->hiddenColumns));

        // Return clean readable column names
        return array_map(
            fn($col) => Str::title(str_replace(['_', '-'], ' ', $col)),
            $columns
        );
    }

    protected function isAdmin($user): bool
    {
        return isset($user->role_name) && in_array(strtolower($user->role_name), ['admin', 'superadmin', 'super admin']);
    }
}
