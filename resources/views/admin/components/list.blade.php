<div class="list">

    <div class="list__top">

        <div class="dropdown bulk-actions">
            <button class="bulk-actions__btn btn dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Bulk actions
            </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button disabled id="deleteBulkBtn" class="dropdown-item" href="#" data-popshow="deletePopup">Delete
                    selected
                </button>
            </div>

        </div>

        @if(isset($search) && !empty($search->toHtml()))
            <div class="list__search-text">Searching for <b>{{ $search }}</b></div>
            <a class="list__clear-search" href="{{ $route }}">Clear search</a> @endif

        @component('admin/components/amount', ['items' => $items])
            @slot('single') {{ $singular }} @endslot
            @slot('plural') {{ $plural }} @endslot
        @endcomponent

    </div>

    <table class="table">
        <thead>
        <tr>

            <td class="list__td list__primary" style="width: 50px">

                <input id="bulkCheckbox" type="checkbox">
                <label for="bulkCheckbox"></label>

            </td>

            @foreach($list_options as $sort)

                @component('admin/components/list_th')
                    @slot('title') {{ $sort['title'] }} @endslot
                    @slot('value') {{ $sort['sort_value'] }} @endslot
                    @slot('sortable') {{ $sort['sortable'] }} @endslot
                    @slot('sort_column') {{ $sort_column }} @endslot
                    @slot('sort_direction') {{ $sort_direction }} @endslot
                    @slot('per_page') {{ $per_page }} @endslot
                    @slot('search') {{ $search }} @endslot
                    @slot('route') {{ $sort['route'] }} @endslot
                    @slot('list') {{ $list }} @endslot
                    @slot('type') {{ $sort['sort_type'] }} @endslot
                @endcomponent

            @endforeach

            <th class="list__th" scope="col">Actions</th>

        </tr>
        </thead>
        <tbody>

        @if(count($items) === 0)
            <tr>
                <td colspan="3" class="list__column">
                    No {{ $plural }} found.
                </td>
            </tr>
        @endif

        @foreach ($items as $item)

            <tr class="list__column">

            @foreach($list_options as $sort)

                <!-- USER -->
                    @if(strpos($sort['list_type'], 'user') !== false)

                        @if($sort['list_type'] == 'user-name')


                            <input class="list-id" type="hidden" value="{{ $item->id }}">
                            <input class="list-name" type="hidden"
                                   value="{{ $item->first_name }} {{ $item->last_name }}">

                            <td class="list__td list__primary">
                                <input class="list__checkbox" id="styled-checkbox-{{ $item->id }}" type="checkbox">
                                <label for="styled-checkbox-{{ $item->id }}"></label>
                            </td>

                            <td class="list__td list__primary">
                                <a class="list__link" href="/admin/users/{{ $item->id }}/edit">
                            <span class="list__img"
                                  style="background-color: {{ $item->color }}; background-image: url('@if(count($item->images) > 0)/{{ $item->images[0]->path_thumbnail }} @else{{ userAvatar($item->id) }} @endif'"></span>

                                    <span class="list__title">{{ $item->first_name }} {{ $item->last_name }}</span>
                                </a>
                                <i class="list-dropdown__show fas fa-eye"></i>
                            </td>

                        @elseif($sort['list_type'] == 'user-email')
                            <td class="list__td">{{ $item->email }}</td>
                        @elseif($sort['list_type'] == 'user-role')
                            <td class="list__td">{{ ucfirst($item->roles->pluck('name')[0]) }}</td>

                            <td class="list__td">

                                <a href="/admin/users/{{ $item->id }}/edit" class="list__edit">Edit</a>

                                @if(!canDeleteUsers(Auth::user(), $item))
                                    <span data-toggle="tooltip"
                                          title="You do not have permission to delete this user."> @endif

                                        <button @if (!canDeleteUsers(Auth::user(), $item)) disabled
                                                @endif class="list__delete"
                                                data-popshow="deletePopup">Delete</button>

                                        @if(!canDeleteUsers(Auth::user(), $item))</span>@endif

                            </td>

            </tr>
            <tr class="list-dropdown list-dropdown__hidden">
                <td colspan="10">

                    <i class="list-dropdown__delete fas fa-trash-alt" data-popshow="deletePopup"></i>
                    <a href="/admin/users/{{ $item->id }}/edit" class="list-dropdown__edit"><i class="fas fa-edit"></i></a>

                    <div class="list-dropdown__row">
                        <div class="list-dropdown__header">Email</div>
                        <div class="list-dropdown__text">{{ $item->email }}</div>
                    </div>
                    <div class="list-dropdown__row">
                        <div class="list-dropdown__header">Role</div>
                        <div class="list-dropdown__text">{{ ucfirst($item->roles->pluck('name')[0]) }}</div>
                    </div>


                </td>
            </tr>

            @endif


            @endif




            <!-- ARTICLES -->

            @if(strpos($sort['list_type'], 'article') !== false)

                @if($sort['list_type'] == 'article-title')

                    <input class="list-id" type="hidden" value="{{ $item->id }}">
                    <input class="list-name" type="hidden" value="{{ $item->title }}">

                    <td class="list__td list__primary">
                        <input class="list__checkbox" id="styled-checkbox-{{ $item->id }}" type="checkbox">
                        <label for="styled-checkbox-{{ $item->id }}"></label>
                    </td>

                    <td class="list__td list__primary">
                        <a class="list__link" href="/admin/articles/{{ $item->id }}/edit">
                            <span class="list__img"
                                  style="background-color: {{ $item->color }}; background-image: url('@if(count($item->images) > 0)/{{ $item->images[0]->path_thumbnail }} @else{{ userAvatar($item->id) }} @endif'"></span>

                            <span class="list__title">{{ $item->title }}</span>
                        </a>
                        <i class="list-dropdown__show fas fa-eye"></i>
                    </td>
                @elseif($sort['list_type'] == 'article-author')
                    <td class="list__td">{{ $item->user->first_name }} {{ $item->user->last_name }}</td>
                @elseif($sort['list_type'] == 'article-published')
                    <td class="list__td">@if($item->published == 0) No @else Yes @endif</td>
                @elseif($sort['list_type'] == 'article-updated')
                    <td class="list__td">
                        {{ $item->updated_at->diffForHumans() }}
                    </td>

                    <td class="list__td">

                        <a href="/a/{{ $item->slug }}" target="article-{{ $item->id }}">View</a>

                        <a href="/admin/articles/{{ $item->id }}/edit" class="list__edit">Edit</a>

                        @if(!canDeleteArticles(Auth::user(), $item))
                            <span data-toggle="tooltip"
                                  title="You do not have permission to delete this user."> @endif

                                <button @if (!canDeleteArticles(Auth::user(), $item)) disabled
                                        @endif class="list__delete"
                                        data-popshow="deletePopup">Delete</button>

                                @if(!canDeleteArticles(Auth::user(), $item))</span>@endif

                    </td>

                    </tr>
                    <tr class="list-dropdown list-dropdown__hidden">
                        <td colspan="10">

                            <i class="list-dropdown__delete fas fa-trash-alt" data-popshow="deletePopup"></i>
                            <a href="/admin/articles/{{ $item->id }}/edit" class="list-dropdown__edit"><i
                                        class="fas fa-edit"></i></a>

                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Author</div>
                                <div class="list-dropdown__text">{{ $item->user->first_name }} {{ $item->user->last_name }}</div>
                            </div>
                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Status</div>
                                <div class="list-dropdown__text">{{ $item->status }}</div>
                            </div>
                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Updated</div>
                                <div class="list-dropdown__text">     {{ $item->updated_at->diffForHumans() }}</div>
                            </div>

                        </td>
                    </tr>


                @endif

            @endif


            <!-- MEDIA -->
            @if(strpos($sort['list_type'], 'media') !== false)
                @if($sort['list_type'] == 'media-name')



                    <input class="list-id" type="hidden" value="{{ $item->id }}">
                    <input class="list-name" type="hidden" value="{{ $item->name }}">

                    <td class="list__td list__primary">
                        <input class="list__checkbox" id="styled-checkbox-{{ $item->id }}"
                               type="checkbox">
                        <label for="styled-checkbox-{{ $item->id }}"></label>
                    </td>

                    <td class="list__td list__primary">

                            <span class="imageInfo"
                                  data-id="{{ $item->id }}"
                                  data-name="{{ $item->name }}"
                                  data-path="{{ $item->path_medium }}"
                                  data-updated="{{ $item->updated_at->diffForHumans() }}"
                                  data-size="{{ round($item->size / 100000, 2) }} MB"
                                  data-alt="{{ $item->alt }}"
                                  data-title="{{ $item->title }}"
                                  data-resX="{{ $item->resolution_x }}"
                                  data-resY="{{ $item->resolution_y }}"
                                  data-extension="{{ $item->extension }}">
                            </span>

                        <button class="list__link" data-popshow="mediaDetails">
                                <span class="list__img"
                                      style="background-color: {{ $item->color }}; background-image: url('/{{ $item->path_thumbnail }}')"></span>

                            <span class="list__title">{{ $item->name }}</span>

                        </button>
                        <i class="list-dropdown__show fas fa-eye"></i>
                    </td>
                @elseif($sort['list_type'] == 'media-extension')
                    <td class="list__td">{{ $item->extension }}</td>
                @elseif($sort['list_type'] == 'media-size')

                    <td class="list__td">{{ round($item->size / 100000, 2) }} MB</td>
                @elseif($sort['list_type'] == 'media-connections')


                    <td class="list__td">Yes</td>

                    <td class="list__td">

                        <button data-popshow="mediaDetails" class="list__edit">Edit</button>

                        @if(!canDeleteMedia(Auth::user()))
                            <span data-toggle="tooltip"
                                  title="You do not have permission to delete media files."> @endif

                                <button @if (!canDeleteMedia(Auth::user())) disabled
                                        @endif class="list__delete"
                                        data-popshow="deletePopup">Delete</button>

                                @if(!canDeleteMedia(Auth::user()))</span>@endif

                    </td>

                    </tr>
                    <tr class="list-dropdown list-dropdown__hidden">
                        <td colspan="10">

                            <i class="list-dropdown__delete fas fa-trash-alt" data-popshow="deletePopup"></i>
                            <span data-popshow="mediaDetails" class="list-dropdown__edit"><i
                                        class="fas fa-edit"></i></span>

                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Extension</div>
                                <div class="list-dropdown__text">{{ $item->extension }}</div>
                            </div>
                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Size</div>
                                <div class="list-dropdown__text">{{ round($item->size / 100000, 2) }} MB</div>
                            </div>
                            <div class="list-dropdown__row">
                                <div class="list-dropdown__header">Connections</div>
                                <div class="list-dropdown__text">Yes</div>
                            </div>

                        </td>
                    </tr>

                @endif

            @endif


        @endforeach


        @endforeach

        </tbody>
    </table>

    <div class="list__bottom">
        {{ $items->appends($_GET)->links() }}
    </div>

</div>