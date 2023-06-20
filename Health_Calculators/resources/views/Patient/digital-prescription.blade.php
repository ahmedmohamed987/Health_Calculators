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
            <a href="{{ url()->previous() }}" role="button" class="btn-close prescription-close" aria-label="Close"></a>

            <img src="{{ url('img/full-logo-black.png') }}" alt="" class="prescription-logo">
            <span class="prescription-header">Patient prescription</span>
            <span class="prescription-header">Dr. {{ ucwords($prescription->first_name) }} {{ ucwords($prescription->last_name) }}</span>
            <span class="prescription-date">Date: {{ date('d-m-Y', strtotime($prescription->app_date )) }}</span>
            <div class="prescription-line"></div>

            <span class="prescription-header">Patient: {{ ucwords(Session('logged_in_patient')['first_name']) }} {{ ucwords(Session('logged_in_patient')['last_name'])  }}</span>

            <!-- This table is repeated for every medicine -->

            @foreach($medicines as $medicine)

                <table class="w-100 mt-4 prescription-table">

                <tr>
                    <th class="prescription-th">Medicine name</th>
                    <td class="prescription-td center">{{ ucfirst($medicine->name) }}</td>
                </tr>

                <tr>
                    <th class="prescription-th">Dosage</th>
                    <td class="prescription-td center"> {{ $medicine->dosage }}</td>
                </tr>

                <tr>
                    <th class="prescription-th">Period</th>
                    <td class="prescription-td center">{{ $medicine->period }}</td>
                </tr>

                <tr>
                    <th class="prescription-th">Time</th>
                    <td class="prescription-td center">{{ $medicine->time }}</td>
                </tr>

                @if(is_null($medicine->notes))

                @else
                <tr>
                    <th class="prescription-th">Extra notes</th>
                    <td class="prescription-td"> {{ ucfirst($medicine->notes) }}</td>
                </tr>
                @endif

            </table>

            @endforeach

            <footer class="footer">
                <div class="footer-line"></div>
                <span class="footer-span">Tel: {{ $prescription->phone_number }}</span>
                <span class="footer-span mt-2">Email: {{ $prescription->email }}</span>
                @if(!is_null($prescription->detailed_clinic_address))
                <span class="footer-span mt-2">Location: {{ $prescription->detailed_clinic_address }}</span>
                @else
                <span class="footer-span mt-2">Location: {{ $prescription->clinic_address }}</span>
                @endif
            </footer>
        </div>
    </div>
@endsection
