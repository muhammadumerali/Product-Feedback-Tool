@extends('layouts.user')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ trans('user.add_feedback') }}</h1>

                @if(session('message'))
                    <div class="alert alert-info" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('user.feedback.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                    <div class="row">

                        <div class="form-group mb-3 mt-3 col-lg-6">
                            <label class="required" for="title">{{ trans('cruds.feedback.fields.title') }}</label>
                            <input id="title" name="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="Title of Feedback" value="{{ old('title', null) }}" required>

                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group mb-3 mt-3 col-lg-6">
                            <label class="required" for="category_id">{{ trans('cruds.feedback.fields.category') }}</label>
                            <select name="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}" id="category_id" required>
                                @foreach($categories as $id => $category)
                                <option value="{{ old('category_id', $id) }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        
                            @if($errors->has('category_id'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('category_id') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group col-lg-12">
                            <label class="required" for="description">{{ trans('cruds.feedback.fields.description') }}</label>
                            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" id="description" placeholder="Description of Feedback" required></textarea>
                        </div>

                        <div class="form-group col-lg-12">
                            <button class="btn btn-success" type="submit">{{ trans('global.save') }}</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection