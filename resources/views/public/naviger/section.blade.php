@extends('public.ticket.ticket')

@section('content')


<div class="espace-article">
    <div class="d-flex justify-content-center">
        <h2 class="text-light fw-bold">Naviguer les Section et ses Catégorie</h2>
    </div>
</div>

    <div class="d-flex justify-content-between position-relative bottom-44 pt-4" style="bottom: 45VH;">
        <div class="">
            <h4 class="fw-bold">Consultation d'assistance</h4>
        </div>
        <div class="" >
            <a class="btn btn-info" href="#">
                Accueil
            </a>
        </div>
    </div>

<div class="consult-assistance">
    {{-- <div>
        <h4 class="assistance-title bg-secondary text-white">Consultation d'assistance</h4>
    </div> --}}
    <div class="naviger-all row d-flex justify-content-center">
        @foreach ($sections as $section)
            <div class="naviger-section m-3 mb-5">
                <h4 class="d-flex justify-content-center">{{$section->nom}} </h4>
                <span style="font-weight:bold;" class="d-flex justify-content-center">Les Catégorie : </span>
                @foreach ($section->category as $cat)
                    <div>
                        <ul>
                            <li>
                                <span> <a href=" {{ route('helpdesk.liste-article', ['id'=>$cat->id])}} ">{{$cat->nom}}</a>  </span>
                            </li>
                        </ul>
                    </div>
                @endforeach
                    {{-- <a href="{{ route('helpdesk.liste-category') }}">
                        View ALL
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
                        </svg>
                    </a> --}}
            </div>
        @endforeach
    </div>
</div>







@endsection
