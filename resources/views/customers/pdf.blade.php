<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customers Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0 0 5px 0;
            font-size: 22px;
            color: #1e3a8a;
        }

        .header p {
            margin: 0;
            color: #6b7280;
            font-size: 11px;
        }

        .search-info {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 11px;
            color: #1e40af;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #1e3a8a;
            color: white;
            padding: 10px 12px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 9px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }

        .total {
            margin-top: 10px;
            font-weight: bold;
            font-size: 12px;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Customer Records Report</h1>
        <p>Generated on {{ now()->format('F d, Y - h:i A') }}</p>
    </div>

    @if($search)
        <div class="search-info">
            <strong>Filter applied:</strong> "{{ $search }}"
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 40px;">#</th>
                <th>Name</th>
                <th>Address</th>
                <th style="width: 70px;">Gender</th>
                <th style="width: 100px;">Date of Birth</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->gender }}</td>
                <td>{{ $customer->dob }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: #9ca3af; padding: 20px;">
                    No records found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total Records: {{ $customers->count() }}
    </div>

    <div class="footer">
        SIA Laravel &mdash; Customer Management System
    </div>
</body>
</html>
