<!doctype html>
<html lang="en">

<head>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">

    <style>
        .text-center {
            text-align: center !important;
        }

        .text-end {
            text-align: end !important;
        }
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th,
        td {
            background: #FFFFFF !important;
        }

        .head-color {
            background: #fff !important;

        }

        .th-account,
        .td-account {
            background: #fff !important;
        }

        .statement-card {
            border: #000000 !important;
        }

        #signature {
            width: 100%;
            border-bottom: 1px solid black;
        }

        .page {
            max-width: 21cm;
            min-height: 29.7cm;
            padding: 1cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
    <script>

    </script>
</head>

<body>
    <div id="updateMe">
        <div class="modal-body">
            <div class="page">
                <div class="container">
                    <table id="exportTable" class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="text-center head-color" colspan="6">LETTER REQUEST<br>CABUYAO
                                    CITY<br>LGU</th>
                            </tr>
                            <tr>
                                <th colspan="6" class="head-color"></th>
                            </tr>
                            <tr>
                                <th class="head-color">Department</th>
                                <th colspan="3" class="head-color">CABS</th>
                                <th class="head-color">LR No.:</th>
                                <th class="head-color">Date: </th>
                            </tr>
                            <tr>
                                <th class="head-color">Purpose:</th>
                                <td colspan="5" class="head-color">{{ $mailData['purpose'] }}</td>
                            </tr>
                            <tr class="text-center">
                                <th class="head-color">Item No.</th>
                                <th class="head-color">Qty</th>
                                <th class="head-color">Unit</th>
                                <th class="head-color">Item Description</th>
                                <th class="head-color">Estimated Unit Cost</th>
                                <th class="head-color">Estimated Cost</th>
                            </tr>
                        </thead>
                        <tbody class="head-color">
                            <tr>
                                <td class="head-color text-center">{{ $mailData['tableID'] }}</td>
                                <td class="head-color text-center">{{ $mailData['tableQty'] }}</td>
                                <td class="head-color text-center">{{ $mailData['tableUnit'] }}</td>
                                <td class="head-color">{{ $mailData['tableDesc'] }}</td>
                                <td class="head-color"></td>
                                <td class="head-color"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="head-color"></td>
                                <td colspan="4" class="text-end fw-bold head-color">TOTAL:</td>
                                <td class="head-color"></td>
                            </tr>
                            <tr>
                                <td class="head-color"></td>
                                <td colspan="5" class="head-color"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold head-color">Purpose</td>
                                <td colspan="5" class="head-color">{{ $mailData['purpose2'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="head-color"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="head-color"></td>
                                <td colspan="2" class="head-color">Requested by: </td>
                                <td colspan="2" class="head-color">Approved by: </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold head-color">Signature: </td>
                                <td colspan="2" class="head-color"></td>
                                <td colspan="2" class="head-color"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold head-color">Printed Name: </td>
                                <td colspan="2" class="text-center head-color">Ruben L. Morales</td>
                                <td colspan="2" class="text-center head-color">Hon. Dennis Felipe C. Hain
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold head-color">Department: </td>
                                <td colspan="2" class="text-center fw-bold head-color">CABS</td>
                                <td colspan="2" class="text-center fw-bold head-color">City Mayor</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        

    </script>
</body>

</html>
