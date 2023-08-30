<div>
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        {{ $pretitle }}
                    </div>
                    <h2 class="page-title">
                        {{ $title }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @empty(!$grid->bottoms)
                            @foreach ($grid->bottoms as $bottom)
                                <a href="{{ route($bottom['route']) }}" class="btn btn-primary d-none d-sm-inline-block">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    {{ \Illuminate\Support\Str::contains($bottom['label'], '::grids') ? __($bottom['label']) : $bottom['label'] }}
                                </a>
                            @endforeach
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card mb-3">

                        @if ($grid->getRows()->isEmpty())
                            <div class="empty">
                                <div class="empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-mood-empty" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M9 10l.01 0"></path>
                                        <path d="M15 10l.01 0"></path>
                                        <path d="M9 15l6 0"></path>
                                    </svg>
                                </div>
                                <p class="empty-title">No results found</p>
                                <p class="empty-subtitle text-secondary">
                                    Try adjusting your search or filter or creating a new record to find a records.
                                </p>
                            </div>
                        @endif

                        @if (!$grid->getRows()->isEmpty())
                            <div class="table-responsive">

                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            @foreach ($grid->getLabels() as $label)
                                                <th>{{ $label }}</th>
                                            @endforeach
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grid->getRows() as $row)
                                            <tr>
                                                @foreach ($row['columns'] as $column)
                                                    <td>{!! $column !!}</td>
                                                @endforeach
                                                <td align="right">
                                                    @foreach ($row['calls'] as $call => $action)
                                                        @if ($action['type'] == 'route')
                                                            <a class="btn btn-sm btn-{{ $action['color'] ?? 'primary' }}"
                                                                href="{{ route($action['route'], [$row['primary']]) }}">
                                                                {{ \Illuminate\Support\Str::contains($call, '::grids') ? __($call) : $call }}
                                                            </a>
                                                        @endif
                                                    @endforeach

                                                    @if ($canRemoveRow)
                                                        <button class="btn btn-sm btn-danger"
                                                            wire:click="removeRow({{ $row['primary'] }})">Remove</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        @endif
                    </div>

                    {{ $grid->getLinks() }}
                </div>
            </div>
        </div>
    </div>
</div>
