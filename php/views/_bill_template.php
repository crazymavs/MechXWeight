<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transaction Bill</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
        }

        .first_section {
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .field {
            display: flex;
            justify-content: space-between;
            margin: 6px 0;
        }

        .field label {
            font-weight: bold;
        }

        hr {
            border: 1px dashed #000;
            margin: 15px 0;
        }

        .total {
            margin-top: 20px;
            font-weight: bold;
            font-size: 1.2em;
            text-align: right;
        }

        @media print {
            body {
                border: none;
                margin: 0;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <h2>Transaction Bill</h2>

    <!-- Company Details -->
    <div class="first_section">
        <div>
            <img id="company_logo" src="" alt="Company Logo" style="max-width: 100px; max-height: 100px; display: block; margin: auto;" />
        </div>
        <div>
            <div class="field"><label>Company Name:</label>
                <div id="company_name"></div>
            </div>
            <div class="field"><label>Company Address:</label>
                <div id="company_addr"></div>
            </div>
            <div class="field"><label>Company Phone:</label>
                <div id="company_phone"></div>
            </div>
        </div>

    </div>

    <hr />

    <!-- Transaction Details -->
    <div class="field"><label>Ticket No.:</label>
        <div id="ticket_no"></div>
    </div>
    <div class="field"><label>Date:</label>
        <div id="date"></div>
    </div>
    <div class="field"><label>Time:</label>
        <div id="time"></div>
    </div>
    <div class="field"><label>Vehicle No.:</label>
        <div id="vehicle_no"></div>
    </div>
    <div class="field"><label>Party Name:</label>
        <div id="party_name"></div>
    </div>
    <hr />
    <div class="field"><label>Material:</label>
        <div id="material"></div>
    </div>
    <div class="field"><label>Weight (kg):</label>
        <div id="weight"></div>
    </div>
    <div class="field"><label>Charges (₹):</label>
        <div id="charges"></div>
    </div>
    <hr />
    <div class="field"><label>Net Weight (kg):</label>
        <div id="net_weight"></div>
    </div>
    <?php
    include_once `php/config.php`;
    ?>
    <script>
        // Parse query parameters from URL
        const params = new URLSearchParams(window.location.search);

        // Helper to safely get param or fallback
        function getParam(key, fallback = '') {
            return params.has(key) ? params.get(key) : fallback;
        }

        // Map URL params to company fields
        const company = {
            company_name: getParam('company_name', 'N/A'),
            company_addr: getParam('company_addr', 'N/A'),
            company_phone: getParam('company_phone', 'N/A'),
            company_logo: getParam('company_logo', ''),
        };
        console.log('Company Data:', company);


        // Map URL params to transaction fields
        const record = {
            ticket_no: getParam('ticket_no', 'N/A'),
            date: getParam('date', 'N/A'),
            time: getParam('time', 'N/A'),
            vehicle_no: getParam('vehicle_no', 'N/A'),
            party_name: getParam('party_name', 'N/A'),
            material: getParam('material', 'N/A'),
            weight: getParam('weight', '0'),
            charges: getParam('charges', '0'),
            net_weight: getParam('net_weight', '0'),
        };

        // Fill company details
        document.getElementById('company_name').textContent = company.company_name;
        document.getElementById('company_addr').textContent = company.company_addr;
        document.getElementById('company_phone').textContent = company.company_phone;
        document.getElementById('company_logo').src = <?= $asset_base ?> + company.company_logo;

        // Fill transaction details
        document.getElementById('ticket_no').textContent = record.ticket_no;
        document.getElementById('date').textContent = record.date;
        document.getElementById('time').textContent = record.time;
        document.getElementById('vehicle_no').textContent = record.vehicle_no;
        document.getElementById('party_name').textContent = record.party_name;
        document.getElementById('material').textContent = record.material;
        document.getElementById('weight').textContent = record.weight;
        document.getElementById('charges').textContent = record.charges;
        document.getElementById('net_weight').textContent = record.net_weight;

        // Optionally trigger print automatically
        window.onload = () => window.print();
    </script>

</body>

</html>