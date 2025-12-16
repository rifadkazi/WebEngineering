import requests
import time
import random

# ==========================================
# CONFIGURATION
# ==========================================
# This URL must match your XAMPP folder structure.
# If your PHP files are in C:/xampp/htdocs/agricare/, this is correct:
SERVER_URL = "http://localhost/agricare/insert.php"

print("-----------------------------------------------")
print("   AgriCare IoT Virtual Sensor Simulator       ")
print("-----------------------------------------------")
print(f"Target Server: {SERVER_URL}")
print("Press Ctrl+C to stop the simulation.\n")

while True:
    try:
        # 1. Generate Fake Sensor Data
        # Temperature: Random float between 20.0 and 35.0
        temperature = round(random.uniform(20.0, 35.0), 1)
        
        # Humidity: Random integer between 40% and 90%
        humidity = random.randint(40, 90)
        
        # Soil Moisture: Random integer (simulating analog sensor 0-1023)
        # Low < 300 (Dry), High > 700 (Wet)
        soil_moisture = random.randint(200, 800)

        # 2. Prepare Data to Send
        payload = {
            'temperature': temperature,
            'humidity': humidity,
            'soil_moisture': soil_moisture
        }

        # 3. Send Data via HTTP POST
        response = requests.post(SERVER_URL, data=payload)

        # 4. Check Response
        if response.status_code == 200:
            # Add a timestamp for the log
            timestamp = time.strftime("%H:%M:%S")
            print(f"[{timestamp}] SENT -> Temp: {temperature}°C | Hum: {humidity}% | Soil: {soil_moisture}")
        else:
            print(f"[ERROR] Server responded with code: {response.status_code}")

    except requests.exceptions.ConnectionError:
        print("[ERROR] Could not connect to localhost. Is XAMPP (Apache) running?")
    except Exception as e:
        print(f"[ERROR] An unexpected error occurred: {e}")

    # 5. Wait for 2 seconds before sending next reading
        time.sleep(2)
        import requests
        import time
        import random

    # ==========================================
    # CONFIGURATION
    # ==========================================
    # This URL must match your XAMPP folder structure.
    # If your PHP files are in C:/xampp/htdocs/agricare/, this is correct:
    SERVER_URL = "http://localhost/agricare/insert.php"

    print("-----------------------------------------------")
    print("   AgriCare IoT Virtual Sensor Simulator       ")
    print("-----------------------------------------------")
    print(f"Target Server: {SERVER_URL}")
    print("Press Ctrl+C to stop the simulation.\n")

    while True:
        try:
            # 1. Generate Fake Sensor Data
            # Temperature: Random float between 20.0 and 35.0
            temperature = round(random.uniform(20.0, 35.0), 1)
            
            # Humidity: Random integer between 40% and 90%
            humidity = random.randint(40, 90)
            
            # Soil Moisture: Random integer (simulating analog sensor 0-1023)
            # Low < 300 (Dry), High > 700 (Wet)
            soil_moisture = random.randint(200, 800)

            # 2. Prepare Data to Send
            payload = {
                'temperature': temperature,
                'humidity': humidity,
                'soil_moisture': soil_moisture
            }

            # 3. Send Data via HTTP POST
            response = requests.post(SERVER_URL, data=payload)

            # 4. Check Response
            if response.status_code == 200:
                # Add a timestamp for the log
                timestamp = time.strftime("%H:%M:%S")
                print(f"[{timestamp}] SENT -> Temp: {temperature}°C | Hum: {humidity}% | Soil: {soil_moisture}")
            else:
                print(f"[ERROR] Server responded with code: {response.status_code}")

        except requests.exceptions.ConnectionError:
            print("[ERROR] Could not connect to localhost. Is XAMPP (Apache) running?")
        except Exception as e:
            print(f"[ERROR] An unexpected error occurred: {e}")

        # 5. Wait for 2 seconds before sending next reading
        time.sleep(2)