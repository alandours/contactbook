@extends('layouts.app')

@section('title')
    – Contacts
@endsection

@section('content')
<div id="contactbook">
    <section id="contacts">
        <div class="search-container">
            <i class="fa fa-search"></i>
            <input type="text" name="search" class="search-field" placeholder="Search contacts...">
        </div>
        <ul class="contact-list">

            @php
                $firstLetter = null;
            @endphp
        
            @foreach($contacts as $contact)

                @php
                    $firstChar = mb_substr(ucfirst($contact->name), 0, 1);
                @endphp

                @if($firstChar != $firstLetter)

                    @php
                        $firstLetter = $firstChar;
                    @endphp

                    <li class="letter">{{ $firstLetter }}</li>

                @endif

                <li class="contact"><a href="{{ url('contacts/'.$contact->id) }}" data-id="{{ $contact->id }}" class="contact-link">{{ $contact->full_name }}</a></li>
                
            @endforeach

            @if(count($contacts) == 1)
                <li class="contact-count">1 contact</li>
            @else
                <li class="contact-count">{{ count($contacts) }} contacts</li>
            @endif

        </ul>
    </section>
    <section id="contact-info">
        @if($displayContact != null)

            <a href="{{ url('contacts/'.$displayContact->id.'/edit') }}" class="btn btn-edit"><i class="fa fa-pen"></i>Edit contact</a>
            <a href="{{ url('contacts/'.$displayContact->id) }}" class="btn btn-permalink"><i class="fa fa-lg fa-link"></i></a>

            <img src="{{ asset('img/contacts/'.$displayContact->photo) }}" alt="Profile picture" class="profile-picture">

            <div class="main-info"><h2 class="username">{{ $displayContact->full_name }}</h2>
                @if($displayContact->birthday !== null)
                    <h3 class="age">{{ calculate_age($displayContact->birthday) }}</h3>
                @endif
            </div>
            <div class="secondary-info">

            @if($displayContact->met !== null || $displayContact->birthday !== null || $displayContact->address !== null || count($displayContact->aliases) > 0)

                <ul class="info-section info-first">

                @if($displayContact->met !== null)
                    <li>
                        <span class="info-tag">Met in</span>
                        <p>{{ $displayContact->met }}</p>
                    </li>
                @endif

                @if($displayContact->birthday !== null)
                    <li>
                        <span class="info-tag">Birthday</span>
                        <p>{{ display_birthday($displayContact->birthday) }}</p>
                    </li>
                @endif
                                    
                @if($displayContact->address !== null)
                    <li>
                        <span class="info-tag">Address</span>
                        <a href="https://www.google.com/maps/search/{{ $displayContact->address }}">{{ $displayContact->address }}</a>
                    </li>
                @endif

                @if(count($displayContact->aliases) > 0)
                    <li>
                        <span class="info-tag">Alias</span>
                        <div class="aliases">
                            @foreach($displayContact->aliases as $a)
                                <p>{{ $a->alias }}</p>
                            @endforeach
                        </div>
                    </li>
                @endif

                </ul>
            @endif

            <!-- Info emails -->

            @if(count($displayContact->emails) > 0)
                <ul class="info-section info-email">
                    @foreach($displayContact->emails as $e)
                        <li>
                            <span class="info-tag">{{ get_tag($e->id_type, 'email', $e->custom_tag) }}</span>
                            <a href="mailto:{{ $e->email }}">{{ $e->email }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Info numbers -->

            @if(count($displayContact->numbers) > 0)
                <ul class="info-section info-phone">
                    @foreach($displayContact->numbers as $n)
                        <li>
                            <span class="info-tag">{{ get_tag($n->id_type, 'number', $n->custom_tag) }}</span>
                            <a href="tel:{{ $n->number }}">{{ $n->number }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Info social -->

            @if(count($displayContact->social_networks) > 0)

                @php
                    $social_tag;
                    $social_url;
                    $social_name;
                @endphp

                <ul class="info-section info-social">

                @foreach($displayContact->social_networks as $s)
                    <li>
                    @php
                        switch($s->id_network){
                            case 1:
                                $social_tag = 'Website';
                                $social_url = 'https://www.'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 2:
                                $social_tag = 'Instagram';
                                $social_url = 'https://www.instagram.com/'.$s->username;
                                $social_name = '@'.$s->username;
                                break;
                            case 3:
                                $social_tag = 'Facebook';
                                $social_url = 'https://www.facebook.com/'.$s->username;
                                $social_name = 'facebook.com/'.$s->username;
                                break;
                            case 4:
                                $social_tag = 'Twitter';
                                $social_url = 'https://www.twitter.com/'.$s->username;
                                $social_name = '@'.$s->username;
                                break;
                            case 5:
                                $social_tag = 'Tumblr';
                                $social_url = 'https://'.$s->username.'.tumblr.com';
                                $social_name = $s->username.'.tumblr.com';
                                break;
                            case 6:
                                $social_tag = 'Snapchat';
                                $social_url = 'https://www.snapchat.com/add/'.$s->username;
                                $social_name = '@'.$s->username;
                                break;
                            case 7:
                                $social_tag = 'Linkedin';
                                $social_url = 'https://www.linkedin.com/in/'.$s->username;
                                $social_name = $contact->full_name;
                                break;
                            case 8:
                                $social_tag = 'Flickr';
                                $social_url = 'https://www.flickr.com/'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 9:
                                $social_tag = 'Reddit';
                                $social_url = 'https://www.reddit.com/u/'.$s->username;
                                $social_name = '/u/'.$s->username;
                                break;
                            case 10:
                                $social_tag = 'Letterboxd';
                                $social_url = 'https://www.letterboxd.com/'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 11:
                                $social_tag = 'Skype';
                                $social_url = '#';
                                $social_name = $s->username;
                                break;
                            case 12:
                                $social_tag = 'Behance';
                                $social_url = 'https://www.behance.net/'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 13:
                                $social_tag = 'Pinterest';
                                $social_url = 'https://www.pinterest.com/'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 14:
                                $social_tag = '500px';
                                $social_url = 'https://www.500px.com/'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 16:
                                $social_tag = 'Youtube';
                                $social_url = 'https://www.youtube.com/'.$s->username;
                                $social_name = $s->username;
                                break;
                            case 999:
                                $social_tag = $s->custom_tag;
                                $social_url = 'https://www.'.$s->username;
                                $social_name = $s->username;
                                break;

                        }
                    @endphp
                    <span class="info-tag">{{ $social_tag }}</span><a href="{{ $social_url }}">{{ $social_name }}</a></li>
                @endforeach
                </ul>
            @endif

            <!-- Info notes -->

            @if($displayContact->notes != null)
                <ul class="info-section info-notes">
                    <li>
                        <div>
                            <span class="info-tag">Notes</span>
                            <p>{!! nl2br(e($displayContact->notes)) !!}</p>
                        </div>
                    </li>
                </ul>
            @endif
        @else
            @include('layouts.404')
        @endif
    </section>
</div>
@endsection