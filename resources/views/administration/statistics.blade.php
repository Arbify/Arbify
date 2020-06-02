@extends('administration.layout')

@section('administration-content')
    <div class="container">
        <div class="d-flex justify-content-evenly mb-5">
            <div class="card text-center">
                <div class="card-body">
                            <span class="h2">
                                Unversioned
                                <span class="help-icon" data-toggle="tooltip" data-placement="right"
                                      title="Arbify is still a work-in-progress and doesn't
                                      even use a proper versioning yet.">?</span>
                            </span>
                </div>
                <div class="card-footer font-weight-bold">Version</div>
            </div>
        </div>
        <table class="table table-bordered bg-white">
            <colgroup>
                <col style="width: 35%">
                <col>
                <col style="width: 35%">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <th scope="row"># of users</th>
                <td class="text-right">{{ $numbers['users'] }}</td>
                <th scope="row"># of projects</th>
                <td class="text-right">{{ $numbers['projects'] }}</td>
            </tr>
            <tr>
                <th scope="row"># of secrets</th>
                <td class="text-right">{{ $numbers['secrets'] }}</td>
                <th scope="row"># of messages</th>
                <td class="text-right">{{ $numbers['messages'] }}</td>
            </tr>
            <tr>
                <th scope="row"># of languages</th>
                <td class="text-right">{{ $numbers['languages'] }}</td>
                <th scope="row"># of message values</th>
                <td class="text-right">{{ $numbers['message_values'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
