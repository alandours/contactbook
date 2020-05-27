@extends('layouts.app')

@section('title')
    – Add new contact
@endsection

@section('content')
<form action="{{ url('contacts/add') }}" method="post" enctype="multipart/form-data" class="form">
    @csrf
    <div class="form-content">
        <h2>Add a contact</h2>

        @include('layouts.errors')

        <div class="msg-{{ Session::get('message_type') }}" @if(Session::get('message')) style="display: block" @endif id="msg-flash">{!! Session::get('message') !!}</div> 

        <div class="form-photo-container">
            <label class="label-photo">
                <img src="{{ asset('img/contacts/contact.jpg') }}" alt="Profile picture" class="profile-picture form-photo">
                <span class="upload-photo"><i class="fa fa-camera"></i>Upload a photo</span>
                <input type="file" name="photo" class="photo-input">
            </label>
            <a href="#" class="delete-photo"><i class="fa fa-times"></i>Remove photo</a>
            <input type="checkbox" name="no-photo" class="no-photo">
        </div> 
        <fieldset class="form-personal">
            <legend>Personal information</legend>
            <label>First name
                <input type="text" name="name" {{ Session::get('message_class') }}>
            </label>
            <span class="invalid-msg">{{ Session::get('message_error_name') }}</span>
            <label>Last name<input type="text" name="lastname"></label>
            <label>Birthday<input type="date" name="birthday"></label>
            <label>Address<input type="text" name="address"></label>
            <label>Met in<input type="text" name="met"></label>
            <label>Alias<input type="text" name="alias[]"></label>
            <a href="#" class="btn-new">Add another alias</a>
        </fieldset>
        <fieldset class="form-contact">
            <legend>Contact information</legend>
            <label>Email<input type="text" name="email[]" class="contact-data">
                <select name="email_type[]" class="type-select">
                    <option value="1" selected>Personal</option>
                    <option value="3">Secondary</option>
                    <option value="4">Work</option>
                    <option value="5">Custom</option>
                </select>
                <input type="text" name="email_custom[]" class="input-custom" readonly>
            </label>
            <a href="#" class="btn-new">Add another email</a>
            <label>Phone number<input type="text" name="number[]" class="contact-data">
                <select name="number_type[]" class="type-select">
                    <option value="1">Home</option>
                    <option value="2" selected>Mobile</option>
                    <option value="3">Secondary</option>
                    <option value="4">Work</option>
                    <option value="5">Custom</option>
                </select>
                <input type="text" name="number_custom[]" class="input-custom" readonly>
            </label>
            <a href="#" class="btn-new">Add another number</a>
        </fieldset>
        <fieldset class="form-social">
            <legend>Social networks</legend>
            <label>Usename<input type="text" name="username[]">
                <select name="social_network[]" class="type-select-social">
                    @foreach($networks as $n)
                        <option value="{{ $n->id }}" {{ ($n->id == 1)? 'selected' : '' }} >{{ ucfirst($n->name) }}</option>
                    @endforeach
                    <option value="{{ $custom['id'] }}">{{ ucfirst($custom['name']) }}</option>
                </select>
                <input type="text" name="social_custom[]" class="input-custom" readonly>
            </label>
            <a href="#" class="btn-new">Add another website</a>
        </fieldset>
        <fieldset class="form-notes">
            <legend>Notes</legend>
            <textarea name="notes"></textarea>
        </fieldset>
    </div>
    <div class="button-container">
        <div class="button-background">
            <button class="btn btn-s">Add contact</button>
        </div>
    </div>
</form>
@endsection