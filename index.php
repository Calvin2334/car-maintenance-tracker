<!DOCTYPE html>
<html>
<head>
    <title>Car Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef2f7, #dfe9f3);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 720px;
            margin: 50px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            border-top: 5px solid #2c7be5;
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
            color: #2c3e50;
            letter-spacing: 1px;
        }

        .top-link {
            text-align: center;
            margin-bottom: 25px;
        }

        .top-link a {
            text-decoration: none;
            color: #2c7be5;
            font-weight: bold;
        }

        .top-link a:hover {
            color: #1a5fcc;
        }

        h3 {
            border-left: 5px solid #2c7be5;
            padding-left: 12px;
            margin-top: 30px;
            color: #34495e;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: 600;
            color: #2f3640;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            transition: 0.2s ease;
            background: #fafafa;
        }

        input:focus {
            outline: none;
            border-color: #2c7be5;
            background: #fff;
            box-shadow: 0 0 5px rgba(44,123,229,0.3);
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            background: linear-gradient(135deg, #2c7be5, #1a5fcc);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(44,123,229,0.3);
        }

        .section {
            margin-top: 22px;
            padding: 10px;
            border-radius: 10px;
            background: #f8f9fb;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Book Car Appointment</h1>

    <div class="top-link">
        <a href="admin_login.php">Admin Login</a> |
	<a href="customer_login.php">Customer Login</a> |
	<a href="customer_signup.php">Sign up</a>
    </div>

    <form action="insert.php" method="POST">

        <div class="section">
            <h3>Customer Information</h3>

            <div class="row">
                <div>
                    <label>First Name</label>
                    <input type="text" name="first_name" required>
                </div>

                <div>
                    <label>Last Name</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>

            <label>Phone</label>
            <input type="text" name="phone" required>

            <label>Email</label>
            <input type="text" name="email" required>
        </div>

        <div class="section">
            <h3>Car Information</h3>

            <div class="row">
                <div>
                    <label>Make</label>
                    <input type="text" name="make" required>
                </div>

                <div>
                    <label>Model</label>
                    <input type="text" name="model" required>
                </div>
            </div>

            <div class="row">
                <div>
                    <label>Year</label>
                    <input type="text" name="year" required>
                </div>

                <div>
                    <label>License Plate</label>
                    <input type="text" name="license_plate" required>
                </div>
            </div>
        </div>

        <div class="section">
            <h3>Appointment Details</h3>

            <div class="row">
                <div>
                    <label>Date</label>
                    <input type="date" name="appointment_date" required>
                </div>

                <div>
                    <label>Time</label>
                    <input type="time" name="appointment_time" required>
                </div>
            </div>
        </div>

        <button type="submit">Submit Appointment</button>

    </form>

</div>

</body>
</html>