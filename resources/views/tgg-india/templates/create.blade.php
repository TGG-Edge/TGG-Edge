@extends('tgg-india.layouts.app')

@section('title', 'Create Template')

@section('content')
<div class="admin-container">
<h4 class="trainer-heading">Create Template</h4>

@include('tgg-india.layouts.includes.message')
@php
    $user = auth('web2')->user();
@endphp
<form method="POST"
      action="{{ isset($template) ? route('tgg-india.templates.update',[$template->id, $user->role_key]) : route('tgg-india.templates.store',[$user->role_key]) }}">
@csrf
@if(isset($template)) @method('PUT') @endif

<div class="row g-3">

    <div class="col-md-6">
        <label>Template Name</label>
        <input type="text" name="name" class="form-control"
               value="{{ $template->name ?? '' }}">
    </div>

    <div class="col-md-6">
        <label>Type</label>
        <select name="type" class="form-control">
            @foreach(['email','whatsapp','sms','notification'] as $type)
                <option value="{{ $type }}"
                @selected(($template->type ?? '')==$type)>
                {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label>Subject</label>
        <input type="text" name="title" class="form-control"
               value="{{ $template->title ?? '' }}">
    </div>

    <div class="col-md-6">
        <label>Invite link</label>
        <input type="text" name="invite_link" class="form-control"
               value="{{ $template->invite_link ?? '' }}">
    </div>

    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <div class="col-12">
        <label>Template Body</label>
        <textarea name="body" class="form-control js-ckeditor" rows="6">
        {!! $template->content['body'] ?? '<div style="font-family:Arial, Helvetica, sans-serif; background:#f4f6f8; padding:20px; text-wrap:auto;">
  <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:6px; overflow:hidden;">

    <!-- Header -->
    <div style="background:#0b5ed7; padding:20px; text-align:center; color:#ffffff;">
      <h2 style="margin:0;">TGG India</h2>
      <p style="margin:5px 0 0;">Platform Invitation</p>
    </div>

    <!-- Content -->
    <div style="padding:25px; color:#333333; font-size:15px; line-height:1.6;">
      <p>Hello <strong>[[name]]</strong>,</p>

      <p>
        You have been invited to join the <strong>TGG India</strong> platform.
        We’re excited to welcome you!
      </p>

      <p>
        By joining TGG India, you’ll be able to securely access our services,
        manage your account, and stay connected with our team.
      </p>

      <!-- Button -->
      <div style="text-align:center; margin:30px 0;">
        <a href="[[invite_link]]" 
           style="background:#0b5ed7; color:#ffffff; padding:12px 28px;
                  text-decoration:none; border-radius:4px; font-size:16px; display:inline-block;">
          Accept Invitation
        </a>
      </div>

      <p style="font-size:14px; color:#666666;">
        If the button above does not work, copy and paste the link below into your browser:
      </p>

      <p style="font-size:14px; word-break:break-all;">
        [[invite_link]]
      </p>

      <p>
        Best regards,<br>
        <strong>TGG India Team</strong>
      </p>
    </div>

    <!-- Footer -->
    <div style="background:#f1f1f1; padding:12px; text-align:center; font-size:12px; color:#777777;">
      © [[year]] TGG India. All rights reserved.
    </div>

  </div>
</div>
' !!}</textarea>
       <small class="text-muted">
            Use [[name]], [[email]]
        </small>

    </div>

    {{-- <div class="col-12">
        <label>Variables (comma separated)</label>
        <input type="text" name="variables" class="form-control"
               value="{{ isset($template) ? implode(',', $template->content['variables'] ?? []) : '' }}">
    </div> --}}

</div>

<button class="btn btn-primary mt-3">Save</button>

</form>
</div>
@endsection
