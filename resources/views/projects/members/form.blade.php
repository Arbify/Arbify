@extends('layout')

@section('content')
    <div class="container">
        @formsection(isset($member) ? "Edit {$member->user->username} in $project->name" : "Add member to $project->name")
            @isset($member)
                <form method="POST" action="{{ route('project-members.update', [$project, $member]) }}">
                @method('PATCH')
            @else
                <form method="POST" action="{{ route('project-members.store', $project) }}">
            @endisset

                @csrf
                @empty($member)
                    <div class="form-group row">
                        <label for="user_id" class="col-md-4 col-form-label text-md-right">User</label>

                        <div class="col-md-6">
                            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required autofocus>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(old('user_id', $member->user_id ?? '') == $user->id) selected @endif>
                                        {{ $user->email }} ({{ $user->username }})
                                    </option>
                                @endforeach
                            </select>

                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endempty

                <div class="form-group row">
                    <span class="col-md-4 col-form-label text-md-right">Project role</span>

                    <div class="col-md-6 pt-2">
                        @php
                            use \Arbify\Models\ProjectMember;
                            $lead = ProjectMember::ROLE_LEAD;
                            $memberRole = ProjectMember::ROLE_MEMBER;
                            $translator = ProjectMember::ROLE_TRANSLATOR;

                            $oldRole = (int) old('role', $member->role ?? $memberRole);
                        @endphp
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="role.lead" name="role" value="{{ $lead }}" class="custom-control-input"
                                   @if($oldRole === $lead) checked @endif required>
                            <label class="custom-control-label" for="role.lead">
                                <b class="d-block">Lead</b>
                                <span class="d-block mt-1 mb-2">Can manage project and its members.</span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="role.member" name="role" value="{{ $memberRole }}" class="custom-control-input"
                                   @if($oldRole === $memberRole) checked @endif required>
                            <label class="custom-control-label" for="role.member">
                                <b class="d-block">Member</b>
                                <span class="d-block mt-1 mb-2">Can access project messages and its values and project members.</span>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control">
                            <input type="radio" id="role.translator" name="role" value="{{ $translator }}" class="custom-control-input"
                                   @if($oldRole === $translator) checked @endif required>
                            <label class="custom-control-label" for="role.translator">
                                <b class="d-block">Translator</b>
                                <span class="d-block mt-1 mb-2">Can access only message values.</span>
                            </label>
                        </div>

                        @error('role')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="allowed_languages" class="col-md-4 col-form-label text-md-right">Allowed languages</label>

                    <div class="col-md-6">
                        <input type="text" class="form-control-plaintext allowed_languages-all" value="All">

                        <div id="allowed_languages_group">
                            <select name="allowed_languages[]" id="allowed_languages"
                                    class="form-control @error('allowed_languages.*') is-invalid @enderror" required multiple>
                                @include('partials.languages-options', [
                                    'languages' => $project->languages,
                                    'selected' => function($language) use($member) {
                                        return in_array($language->id, old(
                                            'allowed_languages',
                                            !is_null($member) && $member->isTranslator() ?
                                                $member->allowedLanguages->pluck('id')->toArray()
                                                : []
                                        ));
                                    },
                                ])
                            </select>

                            @error('allowed_languages.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            @isset($member)
                                Update member
                            @else
                                Add member
                            @endisset
                        </button>
                    </div>
                </div>
            </form>
        @endformsection
    </div>
@endsection

@push('scripts')
    <script>
        $('#user_id').selectpicker({
            liveSearch: true,
        });

        $('#allowed_languages').selectpicker({
            liveSearch: true,
            actionsBox: true,
            selectedTextFormat: 'count',
        });

        toggleAllowedLanguages();
        $('[name=role]').change(() => toggleAllowedLanguages());

        function toggleAllowedLanguages() {
            console.log('siem');
            if ($('#role\\.translator').is(':checked')) {
                $('#allowed_languages').attr('disabled', false);
                $('.allowed_languages-all').css('display', 'none');
                $('#allowed_languages_group').css('display', 'flex');
            } else {
                $('#allowed_languages').attr('disabled', true);
                $('.allowed_languages-all').css('display', 'block');
                $('#allowed_languages_group').css('display', 'none');
            }
        }
    </script>
@endpush
