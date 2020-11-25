@extends('layouts.app')

@if(!isset($category))
    @section('title', 'Új kategória')
@else
    @section('title', 'Kategória szerkesztés')
@endif


@section('content')
    <div class="container">
        <form action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name">Név</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Név" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <h6>Termékek-ek</h6>
            @forelse ($items as $item)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $item->id }}" id="item{{ $loop->iteration }}" name="items[]">
                    <label class="form-check-label" for="item{{ $loop->iteration }}">
                        {{ $item->name }}
                    </label>
                </div>
            @empty
                <p>Nincsenek termékek</p>
            @endforelse

            <div class="text-center my-3">
                <button type="submit" class="btn btn-primary">Létrehozás</button>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('input[type=file]').on('change', (e) => {
            console.log('changed')
            let target = $(e.currentTarget)
            let fileName = target.val()
            target.next('.custom-file-label').html(fileName)
        })
    </script>
@endsection
