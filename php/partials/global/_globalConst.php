<?php
$massFlowMeterFAQs = [
    [
        "question" => "Sensor is not reading flow — what should I check first?",
        "answer" => "
            <ol>
                <li>Ensure the process is actually flowing (no blockage or closed valve).</li>
                <li>Verify transmitter is receiving power.</li>
                <li>Check signal wiring between sensor and transmitter (especially RS-485 if remote).</li>
                <li>Look for any active fault or alert codes on the transmitter display or in software (e.g., ProLink III).</li>
            </ol>"
    ],
    [
        "question" => "Sensor shows zero flow, but there is confirmed flow in the line.",
        "answer" => "
            <ol>
                <li>Confirm the flow direction matches the arrow on the sensor body.</li>
                <li>Check for air or gas bubbles in liquid lines (especially for horizontal installation).</li>
                <li>Verify density and zero calibration – perform a \"zero trim\" if needed.</li>
                <li>Inspect for pipe vibration or mounting stress affecting sensor signals.</li>
            </ol>"
    ],
    [
        "question" => "Intermittent signal loss or communication failure with transmitter.",
        "answer" => "
            <ol>
                <li>Inspect RS-485 cabling or MVD Direct Connect link – check for broken wires or loose terminals.</li>
                <li>Ensure cable shield is properly grounded.</li>
                <li>Check grounding practices – both sensor and transmitter should be grounded per manual.</li>
                <li>Confirm cable lengths are within spec (≤1000 ft for 18 AWG, ≤300 ft for 22 AWG).</li>
            </ol>"
    ],
    [
        "question" => "Transmitter shows “Drive Gain High” or “Sensor Fault.”",
        "answer" => "
            <ol>
                <li>May indicate fluid buildup, corrosion, or damaged sensor tube.</li>
                <li>Check process conditions – are operating temperatures/pressures within limits?</li>
                <li>If sensor was recently installed or cleaned, ensure tubes are not damaged.</li>
                <li>Contact Emerson if repeated or cannot be cleared.</li>
            </ol>"
    ],
    [
        "question" => "Reading is fluctuating excessively.",
        "answer" => "
            <ol>
                <li>Confirm if flow itself is pulsating (e.g., positive displacement pump).</li>
                <li>Check for entrained gas, which causes density and mass flow instability.</li>
                <li>Ensure sensor is properly mounted with no pipe stress or vibration.</li>
                <li>Review if process has changing temperature/viscosity causing variation.</li>
            </ol>"
    ],
    [
        "question" => "Mass flow value is inaccurate.",
        "answer" => "
            <ol>
                <li>Re-check fluid density setup in the transmitter (if not auto-detect).</li>
                <li>Perform a “zero calibration” with no flow and fluid filled.</li>
                <li>Look for coating or debris inside the sensor that may affect mass response.</li>
                <li>Validate against a secondary calibrated flow meter, if available.</li>
            </ol>"
    ],
    [
        "question" => "Device not detected in Modbus/Fieldbus network.",
        "answer" => "
            <ol>
                <li>Verify device address, baud rate, and protocol match your system.</li>
                <li>Use Emerson’s ProLink III software for direct diagnostics.</li>
                <li>Check termination resistors in RS-485 line.</li>
                <li>Confirm transmitter has been set to “Online” mode and not “Simulate.”</li>
            </ol>"
    ],
    [
        "question" => "What does a flashing red LED or transmitter alarm mean?",
        "answer" => "
            <ol>
                <li>Red LED typically signals a fault condition.</li>
                <li>Use local display or diagnostics interface (ProLink III or HART communicator) to check:
                    <ol type=\"a\">
                        <li>Alert Codes (e.g., A102 = sensor not detected)</li>
                        <li>Health status (sensor/transmitter)</li>
                        <li>Diagnostic logs</li>
                    </ol>
                </li>
            </ol>"
    ],
    [
        "question" => "What is the correct way to reset the sensor/transmitter?",
        "answer" => "
            <ol>
                <li>Power cycle the unit (disconnect and reconnect power).</li>
                <li>Use menu interface to \"Reset Diagnostics\" if available.</li>
                <li>On some transmitters, “Factory Reset” option may exist—use with caution.</li>
            </ol>"
    ],
    [
        "question" => "How can I perform a Zero Calibration (Zero Trim)?",
        "answer" => '
            <ol>
                <li>Ensure sensor is completely full of fluid but not flowing.</li>
                <li>Temperature must be stable.</li>
                <li>From transmitter or ProLink:
                    <ol type=\"a\">
                        <li>Navigate to “Zero Trim” or “Zero Calibration”.</li>
                        <li>Follow prompt to perform operation.</li>
                    </ol>
                </li>
                <li>Log the new zero value for reference.</li>
            </ol>'
            
    ]
];

$levelTransmitterFAQs = [
    [
        "question" => "How does the Rosemount 3408 operate?",
        "answer" => "
            <ol>
                <li>The 3408 uses 80 GHz FMCW radar to emit high-frequency microwave signals toward the product surface.</li>
                <li>The reflected signal is processed to determine level, distance, and volume.</li>
                <li>It is non-contacting — ideal for liquids, slurries, and solids.</li>
                <li>Smart Echo Lock filtering ensures accuracy in challenging tank geometries.</li>
            </ol>"
    ],
    [
        "question" => "How do I verify that the transmitter is working correctly?",
        "answer" => "
            <ol>
                <li>Use the Local Display (LCD) to check live values, diagnostics, and alerts.</li>
                <li>Use loop test to simulate 4–20 mA output and verify loop integrity.</li>
                <li>Use built-in test functions (manual or scheduled) to validate electronics and signal chain.</li>
                <li>No need to remove the transmitter or interrupt the process.</li>
            </ol>"
    ],
    [
        "question" => "What routine maintenance is required?",
        "answer" => "
            <ol>
                <li>Every 6–12 months, visually inspect the antenna/lens for corrosion, buildup, or condensation.</li>
                <li>Clean the antenna with a soft cloth and isopropyl alcohol if needed.</li>
                <li>Verify proper grounding and cable integrity.</li>
                <li>Cross-check transmitter configuration and output against actual tank level.</li>
                <li>Run Smart Meter Verification (available separately from Emerson).</li>
            </ol>"
    ],
    [
        "question" => "How do I clean the sensor?",
        "answer" => "
            <ol>
                <li>Ensure the transmitter is powered OFF or process is in a safe state.</li>
                <li>Open the vessel or nozzle if accessible.</li>
                <li>Gently wipe the antenna lens with a non-abrasive cloth.</li>
                <li>Use mild detergent or isopropyl alcohol to remove any buildup.</li>
                <li>Avoid using high-pressure water jets or abrasive cleaning tools.</li>
            </ol>"
    ],
    [
        "question" => "Can I recalibrate the 3408 transmitter?",
        "answer" => "
            <ol>
                <li>Radar transmitters don’t need recalibration like pressure or ultrasonic devices.</li>
                <li>Instead, configure the URV and LRV (Upper and Lower Range Values).</li>
                <li>Use the LCD or software to perform empty/full calibration or zeroing.</li>
                <li>Radar Master software provides a Guided Setup for reconfiguration.</li>
            </ol>"
    ],
    [
        "question" => "What is the correct installation orientation?",
        "answer" => "
            <ol>
                <li>Mount the transmitter perpendicular to the liquid surface.</li>
                <li>Avoid directing it toward tank walls, agitators, or other internal obstructions.</li>
                <li>Ensure a clear beam path with no obstacles in the radar cone.</li>
                <li>Maintain a minimum of 200 mm clearance from the beam cone to tank internals.</li>
            </ol>"
    ],
    [
        "question" => "What alerts should I watch out for during operation?",
        "answer" => "
            <ol>
                <li><strong>Electronics Failure</strong> – Indicates an internal hardware fault; may require module replacement.</li>
                <li><strong>Echo Lost</strong> – Signal reflection is weak or missing; check for obstruction or antenna contamination.</li>
                <li><strong>SIS Configuration Error</strong> – For safety-rated systems, verify correct configuration.</li>
                <li><strong>Analog Output Saturation</strong> – May indicate improper range values set in configuration.</li>
                <li>Use Radar Master or the LCD to access full diagnostics and log details.</li>
            </ol>"
    ],
    [
        "question" => "What spare parts or accessories are commonly needed?",
        "answer" => "
            <ol>
                <li>Antenna seal kits.</li>
                <li>Housing gaskets.</li>
                <li>Electronics module (replaceable in case of internal fault).</li>
                <li>Optional parts: Display module, wireless adapter, conduit plugs.</li>
                <li>Always specify parts using the device's serial number and model code.</li>
            </ol>"
    ]
];

$massFlowMeterAdminFAQs = [
    [
        "question" => "Is there any documents to perform a Zero Calibration (Zero Trim)?",
        "answer" => '
            <ol>
                <li>You can <a href="/MechXWeight/assets/media/ZeroCalibration-MassFlowMeter.pdf" target="_blank">download the manual</a>.</li>
                <li>You can also <a href="#" data-bs-toggle="modal" data-bs-target="#emersonZeroTransmission">watch the video</a>.</li>
            </ol>'
    ]
];

?>
