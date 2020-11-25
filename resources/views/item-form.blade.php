@extends('layouts.app')

@if(!isset($item))
    @section('title', 'Új termék')
@else
    @section('title', 'Termék szerkesztése')
@endif

@section('content')
    <div class="container">
        <form action="{{ !isset($item) ? route('store.item') : route('update.item', ['id' => $item->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name">Név</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name" name="name" placeholder="Név" value="{{ isset($item) ? trim($item->name) : old('name') }}">
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <label for="description">Leírás</label>
                    <textarea id="description" name="description" class="form-control @error('description')is-invalid @enderror" rows="5">{{ isset($item) ? trim($item->description) : old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="price">Ár (€)</label>
                        <input type="number" min="1" max="100" step="0.01" class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" id="price" name="price" placeholder="" value="{{ isset($item) ? $item->price : old('price') }}">
                        @if ($errors->has('price'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('price') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <label for="image" class="col-sm-2">Kép</label>
                <div class="col-sm-10">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input @error('image')is-invalid @enderror" id="image" name="image">
                        <label class="custom-file-label" for="image">Válassz képet</label>
                        @error('image')
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('image') }}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <h6>Kategóriák</h6>
            @forelse ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="category{{ $loop->iteration }}" name="categories[]"
                    
                    @if (isset($item))
                        @foreach($itemCategories as $itemCategory)
                            @if($itemCategory->id === $category->id)
                                checked
                            @endif
                        @endforeach
                    @endif>
                    <label class="form-check-label" for="category{{ $loop->iteration }}">
                        {{ $category->name }}
                    </label>
                </div>
            @empty
                <p>Nincsenek kategóriák</p>
            @endforelse

            <div class="text-center my-3">
                <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Szerkesztés' : 'Létrehozás' }}</button>
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
