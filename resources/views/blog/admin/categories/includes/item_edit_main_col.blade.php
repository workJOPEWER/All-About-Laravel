@php
    /**@var \App\Models\BlogCategory $item*/
@endphp

<div class="justify-content-center row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"></div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab">Main Data</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div class="tab-pane active" id="maindata" role="tabpanel">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input name="title" value="{{$item->title}}"
                                   id="title"
                                   type="text"
                                   class="form-control"
                                   minlenght="3"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="slug">Indentificator</label>
                            <input name="slug" value="{{$item->slug}}"
                                   id="slug"
                                   type="text"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Parent</label>
                            <select name="parent_id"
                                    id="parent_id"
                                    class="form-control"
                                    placeholder="Choose category"
                                    required>
                                @foreach($categoryList as $categoryOption)
                                    <option value="{{$categoryOption->id}}"
                                            @if($categoryOption->id == $item->parent_id) selected @endif>
                                        {{$categoryOption->id}}.{{$categoryOption->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea name="description" value="{{$item->slug}}"
                                      id="description"
                                      rows="3"
                                      class="form-control">
                                {{old('description', $item->description)}}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>