@extends('Shared.header')

@section('css')
    <link rel="stylesheet" href="{{url('css/digital-prescription.css')}}">
@endsection

@section('title')
    Digital Prescription
@endsection

@section('content')
<div class="body">
        <div class="prescription-body">

            <!-- THIS LINK SHOULD REFER TO THE PREVIOUS PAGE -->
            <a href="{{route('drprofile')}}" role="button" class="btn-close prescription-close" aria-label="Close"></a>

            <img src="{{url('img/full-logo-black.png')}}" alt="" class="prescription-logo">
            <span class="prescription-header">Patient prescription</span>
            <span class="prescription-header">Dr. {{ ucwords($doctor_info->first_name) }} {{ ucwords($doctor_info->last_name) }}</span>
            <span class="prescription-date">Date: {{ date('j - m - Y', strtotime($apps_worktimes_info->appointment_date )) }}</span>
            <div class="prescription-line"></div>

            <span class="prescription-header">Patient: {{ ucwords($patient_info->first_name) }} {{ ucwords($patient_info->last_name) }}</span>

            <!-- This table is repeated for every medicine -->
            <form action="{{ route('save.prescription', $apps_worktimes_info->app_id) }}" method="POST">
                @csrf
                <table class="w-100 mt-4 prescription-table" id="table">

                    <tr>
                        <th class="prescription-th">Medicine name</th>
                        <td class="prescription-td center">
                            <input type="text" name="medicines[0][name]" class="form-control" placeholder="Add medicine name">
                            @error('medicines.*.name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>

                    </tr>

                    <tr>
                        <th class="prescription-th">Dosage</th>
                        <td class="prescription-td center">
                            <input type="text" name="medicines[0][dosage]" class="form-control" placeholder="Enter the dosage">
                            @error('medicines.*.dosage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>

                    </tr>

                    <tr>
                        <th class="prescription-th">Period</th>
                        <td class="prescription-td center">
                            <input type="text" name="medicines[0][period]" class="form-control" placeholder="Enter the period">
                            @error('medicines.*.period')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>

                    </tr>

                    <tr>
                        <th class="prescription-th">Time</th>
                        <td class="prescription-td center">
                            <input type="text" name="medicines[0][time]" class="form-control" placeholder="Enter the time">
                            @error('medicines.*.time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </td>

                    </tr>

                    <tr>
                        <th class="prescription-th">Extra notes</th>
                        <td class="prescription-td">
                            <input type="text" name="medicines[0][notes]" class="form-control" placeholder="Add Extra notes">
                        </td>
                    </tr>

                </table>

                <div id="tables-div"></div>

                <button class="btn btn-outline-primary pres-btn" id="add-more-medicines" type="button"><i class="fa-solid fa-plus"></i> Add more medicines</button>

                <button class="btn btn-primary pres-btn" type="submit">Submit</button>

            </form>

            <footer class="footer">
                <div class="footer-line"></div>
                <span class="footer-span">Tel: {{ $doctor_info->phone_number }}</span>
                <span class="footer-span mt-2">Email: {{ $doctor_email->email }}</span>
                @if(!is_null($doctor_info->detailed_clinic_address))
                <span class="footer-span mt-2">Location: {{ $doctor_info->detailed_clinic_address }}</span>
                @else
                <span class="footer-span mt-2">Location: {{ $doctor_info->clinic_address }}</span>
                @endif
            </footer>

        </div>
    </div>
@endsection

@section('jquery')
<script>
    var i = 1;
        $("#add-more-medicines").click(function () {
            var html = '';

            html += '<div id="table-div" class="mt-3">';
            html += '<span class="prescription-header">Medicine </span>';
            html += '<table class="w-100 mt-4 prescription-table" id="table">';

            html += '<tr>';
            html += '<th class="prescription-th">Medicine name</th>';
            html += '<td class="prescription-td center"><input type="text" name="medicines['+i+'][name]" class="form-control" placeholder="Add medicine name"></td>';
            html += '</tr>';

            html += '<tr>';
            html += '<th class="prescription-th">Dosage</th>';
            html += '<td class="prescription-td center"><input type="text" name="medicines['+i+'][dosage]" class="form-control" placeholder="Enter the dosage"></td>';
            html += '</tr>';

            html += '<tr>';
            html += '<th class="prescription-th">Period</th>';
            html += '<td class="prescription-td center"><input type="text" name="medicines['+i+'][period]" class="form-control" placeholder="Enter the period"></td>';
            html += '</tr>';

            html += '<tr>';
            html += '<th class="prescription-th">Time</th>';
            html += '<td class="prescription-td center"><input type="text" name="medicines['+i+'][time]" class="form-control" placeholder="Enter the time"></td>';
            html += '</tr>';

            html += '<tr>';
            html += '<th class="prescription-th">Extra notes</th>';
            html += '<td class="prescription-td center"><input type="text" name="medicines['+i+'][notes]" class="form-control" placeholder="Add Extra notes"></td>';
            html += '</tr>';

            html += '</table>';

            html += '<button class="btn btn-outline-danger pres-btn" id="delete-medicine" type="button"><i class="fa-solid fa-trash"></i> Remove medicine</button>';
            html += '</div>';
            i += 1;

            $('#tables-div').append(html);
        });

        $(document).on('click', '#delete-medicine', function () {
            $(this).closest('#table-div').remove();
            $(this).remove();
        });
</script>
@endsection
