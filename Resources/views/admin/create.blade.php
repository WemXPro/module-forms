@extends(AdminTheme::wrapper(), ['title' => __('Forms'), 'keywords' => 'WemX Dashboard, WemX Panel'])

@section('css_libraries')
    <link rel="stylesheet" href="{{ asset(AdminTheme::assets('modules/summernote/summernote-bs4.css')) }}" />
    <link rel="stylesheet" href="{{ asset(AdminTheme::assets('modules/select2/dist/css/select2.min.css')) }}">
@endsection

@section('js_libraries')
    <script src="{{ asset(AdminTheme::assets('modules/summernote/summernote-bs4.js')) }}"></script>
    <script src="{{ asset(AdminTheme::assets('modules/select2/dist/js/select2.full.min.js')) }}"></script>
@endsection

@section('container')
    <section class="section">
        <div class="section-body">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Create Form') }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.forms.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" onchange="generateSlug()"
                                    value="{{ old('name') }}" required>
                                <small class="form-text text-muted">Name of the form (Not displayed to users)</small>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    value="{{ old('title') }}" required>
                                <small class="form-text text-muted">Title of the form (Displayed to users)</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Description (Optional)</label>
                                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
                                <small class="form-text text-muted">Description of the form (Displayed to users)</small>
                            </div>

                            <div class="form-group">
                                <label for="path">Slug</label>
                                <div class="input-group-prepend">
                                    <div>
                                        <div class="input-group-text">
                                            {{ url('/') }}/forms/
                                        </div>
                                    </div>
                                    <input type="text" name="slug" id="slug" placeholder="example" class="form-control" value="" required="" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="notification_email">Notification Email (Optional)</label>
                                <input type="email" class="form-control" name="notification_email" id="notification_email"
                                    value="{{ old('notification_email') }}">
                                <small class="form-text text-muted">The email where a notification is sent to once this form has been submitted</small>
                            </div>

                            <div class="form-group">
                                <label for="max_submissions">Maximum Submissions (Optional)</label>
                                <input type="number" class="form-control" name="max_submissions" id="max_submissions"
                                    value="{{ old('max_submissions') }}">
                                <small class="form-text text-muted">Maximum amount of times this form can be submitted before its closed. (Leave empty to not set a limit)</small>
                            </div>

                            <div class="form-group">
                                <label for="max_submissions_per_user">Maximum Submissions per user (Optional)</label>
                                <input type="number" class="form-control" name="max_submissions_per_user" id="max_submissions_per_user"
                                    value="{{ old('max_submissions_per_user') }}">
                                <small class="form-text text-muted">Maximum amount of times this form can be submitted by a single user. (If you enable guests, the form can be submitted multiple times by guests!)</small>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4 col-12">
                                    <div class="control-label">Can guest view</div>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="guest" class="custom-switch-input" value="1" checked="" />
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">
                                            Can guests view this form?
                                        </span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4 col-12">
                                    <div class="control-label">Can view own submission</div>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="can_view_submission" onchange="canViewUpdated()" class="custom-switch-input" value="1" checked="" />
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">
                                            Can users view their own submission?
                                        </span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4 col-12" id="can_respond_field">
                                    <div class="control-label">Can users respond</div>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="can_respond" class="custom-switch-input" value="1" checked="" />
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">
                                            Can users respond to to their submission?
                                        </span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4 col-12">
                                    <div class="control-label">Enable Recaptcha</div>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="recaptcha" class="custom-switch-input" value="1" checked="" />
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">
                                            Enable Recaptcha for this form?
                                        </span>
                                    </label>
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        function canViewUpdated() {
            var isChecked = document.getElementsByName('can_view_submission')[0].checked;
            if (isChecked) {
                document.getElementById('can_respond_field').style.display = '';
            } else {
                document.getElementById('can_respond_field').style.display = 'none';
            }
        }

        function generateSlug() {
            var slug = document.getElementById('slug');
            var name = document.getElementById('name').value;
            slug.value = name
                        .toLowerCase() // convert to lowercase
                        .trim() // remove leading and trailing whitespace
                        .replace(/[^\w\s-]/g, '') // remove non-word characters
                        .replace(/[\s_-]+/g, '-') // replace spaces, underscores, and hyphens with a single hyphen
                        .replace(/^-+|-+$/g, ''); // remove leading and trailing hyphens
        }
    </script>
@endsection