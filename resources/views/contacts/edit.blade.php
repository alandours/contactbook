@extends('layouts.app')

@if($contact != null)

    @section('title')
        – Edit {{ $contact->name}}
    @endsection

    @section('content')
        
        <form action="{{ url('contacts/'.$contact->id.'/edit') }}" method="post" enctype="multipart/form-data" class="form">
        @csrf
            <div class="form-content">
                <h2>{{ $contact->full_name }}</h2>

                @include('layouts.errors')

                <div class="msg-{{ Session::get('message_type') }}" @if(Session::get('message')) style="display: block" @endif id="msg-flash">{!! Session::get('message') !!}</div>
                
                <div class="form-photo-container">
                    <label class="label-photo">
                        <img src="{{ url('img/contacts/'.$contact->photo) }}" alt="Profile picture" class="profile-picture form-photo">
                        <span class="upload-photo"><i class="fa fa-camera"></i>Upload a photo</span>
                        <input type="file" name="photo" class="photo-input">
                    </label>

                        @if($contact->photo)
                            <a href="#" class="delete-photo delete-photo-edit"><i class="fa fa-times"></i>Remove photo</a>
                        @else
                            <a href="#" class="delete-photo"><i class="fa fa-times"></i>Remove photo</a>
                        @endif

                    <input type="checkbox" name="no-photo" class="no-photo">
                </div> 
                <fieldset class="form-personal">
                    <legend>Personal information</legend>
                    <label>First name<input type="text" name="name" value="{{ $contact->name }}"></label>
                    <label>Last name<input type="text" name="lastname" value="{{ $contact->lastname }}"></label>
                    <label>Birthday<input type="date" name="birthday" value="{{ $contact->birthday }}"></label>
                    <label>Address<input type="text" name="address" value="{{ $contact->address }}"></label>
                    <label>Met in<input type="text" name="met" value="{{ $contact->met }}"></label>

                        @forelse($contact->aliases as $a)

                            <label>Alias<input type="text" name="alias[]" value="{{ $a->alias }}">
                            <input type="hidden" name="id_alias[]" value="{{ $a->id }}" class="id_field"></label>

                        @empty

                            <label>Alias<input type="text" name="alias[]"></label>

                        @endforelse

                    <a href="#" class="btn-new">Add another alias</a>
                </fieldset>
                <fieldset class="form-contact">
                    <legend>Contact information</legend>
                        @forelse($contact->emails as $e)

                            <label>Email<input type="text" name="email[]" class="contact-data" value="{{ $e->email }}">
                                <select name="email_type[]" class="type-select">
                                    <option value="1" {{ ($e->id_type == 1) ? 'selected' : '' }} >Personal</option>
                                    <option value="3" {{ ($e->id_type == 3) ? 'selected' : '' }} >Secondary</option>
                                    <option value="4" {{ ($e->id_type == 4) ? 'selected' : '' }} >Work</option>
                                    <option value="5" {{ ($e->id_type == 5) ? 'selected' : '' }} >Custom</option>
                                </select>
                                <input type="text" name="email_custom[]" class="input-custom" value="{{ $e->custom_tag }}" {{ ($e->id_type != 5)? 'readonly' : '' }} >
                                <input type="hidden" name="id_email[]" value="{{ $e->id }}" class="id_field">
                            </label>

                        @empty

                            <label>Email<input type="text" name="email[]" class="contact-data">
                                <select name="email_type[]" class="type-select">
                                    <option value="1" selected>Personal</option>
                                    <option value="3">Secondary</option>
                                    <option value="4">Work</option>
                                    <option value="5">Custom</option>
                                </select>
                                <input type="text" name="email_custom[]" class="input-custom" readonly>
                            </label>

                        @endforelse

                    <a href="#" class="btn-new">Add another email</a>

                        @forelse($contact->numbers as $n)

                            <label>Phone number<input type="text" name="number[]" class="contact-data" value="{{ $n->number }}">
                                <select name="number_type[]" class="type-select">
                                    <option value="1" {{ ($n->id_type == 1) ? 'selected' : '' }} >Home</option>
                                    <option value="2" {{ ($n->id_type == 2) ? 'selected' : '' }} >Mobile</option>
                                    <option value="3" {{ ($n->id_type == 3) ? 'selected' : '' }} >Secondary</option>
                                    <option value="4" {{ ($n->id_type == 4) ? 'selected' : '' }} >Work</option>
                                    <option value="5" {{ ($n->id_type == 5) ? 'selected' : '' }} >Custom</option>
                                </select>
                                <input type="text" name="number_custom[]" class="input-custom" value="{{ $n->custom_tag }}" {{ ($n->id_type != 5) ? 'readonly' : '' }} >
                                <input type="hidden" name="id_number[]" value="{{ $n->id }}" class="id_field">
                            </label>

                        @empty

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

                        @endforelse

                    <a href="#" class="btn-new">Add another number</a>
                </fieldset>
                <fieldset class="form-social">
                    <legend>Social networks</legend>

                        @forelse($contact->social_networks as $s)

                            <label>Usename<input type="text" name="username[]" class="contact-data" value="{{ $s->username }}">
                                <select name="social_network[]" class="type-select-social">
                                    @foreach($networks as $n)
                                        <option value="{{ $n->id }}" {{ ($s->id_network == $n->id)? 'selected' : '' }} >{{ ucfirst($n->name) }}</option>
                                    @endforeach
                                    <option value="{{ $custom['id'] }}">{{ ucfirst($custom['name']) }}</option>
                                </select>
                                <input type="text" name="social_custom[]" class="input-custom" value="{{ $s->custom_tag }}" {{ ($s->id_network != 999) ? 'readonly' : '' }} >
                                <input type="hidden" name="id_social[]" value="{{ $s->id }}" class="id_field">
                            </label>

                        @empty

                            <label>Usename<input type="text" name="username[]" class="contact-data">
                                <select name="social_network[]" class="type-select-social">
                                    @foreach($networks as $n)
                                        <option value="{{ $n->id }}" {{ ($n->id == 1)? 'selected' : '' }} >{{ ucfirst($n->name) }}</option>
                                    @endforeach
                                    <option value="{{ $custom['id'] }}">{{ ucfirst($custom['name']) }}</option>
                                </select>
                                <input type="text" name="social_custom[]" class="input-custom" readonly>
                            </label>

                        @endforelse

                    <a href="#" class="btn-new">Add another website</a>
                </fieldset>
                <fieldset class="form-notes">
                    <legend>Notes</legend>
                        @if(!empty($contact->notes))
                            <textarea name="notes">{!! $contact->notes !!}</textarea>
                        @else
                            <textarea name="notes"></textarea>
                        @endif
                </fieldset>
            </div>
            <div class="button-container">
                <div class="button-background">
                    <button class="btn btn-s">Save contact</button>
                    <button class="btn btn-r btn delete-contact" data-id="{{ $contact->id }}">Delete contact</button>
                </div>
            </div>
        </form>
    @endsection

@else

    @section('content')
        @include('layouts.404')
    @endsection

@endif
