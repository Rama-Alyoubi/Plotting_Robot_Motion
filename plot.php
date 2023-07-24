<!DOCTYPE html>
<html>
    <head>
        <title>Robot Path</title>
        <style>
                    
            body {
            background-color: #9AA698;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            }

            label, select, input, button {
            vertical-align: middle;
            margin: 10px;
            border: none;
            }

            label {
            text-align: right;
            }

            button {
            margin-left: 0;
            
            box-shadow: -10px -10px 15px rgba(0, 0, 0, 0.4), 10px 10px 15px rgba(70, 70, 70, 0.12);
            }

            #direction {
                width: 150px;
                height: 60px;
                border-radius: 25px;
                font-size: 16px;
                background-color: #F0F0F0;
                border: none;
                padding: 10px;
                margin-right: 10px;
                outline: none;
                font-family: Arial, sans-serif;
                color: #444;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                }

            #length {
                width: 150px;
                height: 40px;
                border-radius: 25px;
                font-size: 16px;
                background-color: #F0F0F0;
                border: none;
                padding: 10px;
                margin-right: 10px;
                outline: none;
                font-family: Arial, sans-serif;
                color: #444;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }

            #draw {
                width: 150px;
                height: 50px;
                border-radius: 25px;
                font-size: 16px;
                border: none;
                background-color: black; 
                color: #FFF;
                font-weight: bold;
                text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                transition: background-color 0.2s ease-in-out;
            }

            #draw:hover {
                background-color: #333; 
            }

            #draw:focus {
                outline: none;
            }

            #draw:active {
                transform: translateY(2px);
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            }
                
        </style>
    </head>
    <body>
       
        <canvas id="map" width="400" height="800"></canvas>

        
        <label for="direction">Direction:</label>
        <select id="direction">
        <option value="north">North</option>
        <option value="northeast">Northeast</option>
        <option value="east">East</option>
        <option value="southeast">Southeast</option>
        <option value="south">South</option>
        <option value="southwest">Southwest</option>
        <option value="west">West</option>
        <option value="northwest">Northwest</option>
        </select>

        
        <label for="length">Length:</label>
        <input type="number" id="length">

        
        <button id="draw" onclick="drawRoute()">Draw Route</button>


        <script>
        
        let x = 200;
        let y = 200;

        
        function getBearing(direction) {
            switch (direction.toLowerCase()) {
            case "north":
                return Math.PI / 2;
            case "northeast":
                return Math.PI / 4;
            case "east":
                return 0;
            case "southeast":
                return -Math.PI / 4;
            case "south":
                return -Math.PI / 2;
            case "southwest":
                return -3 * Math.PI / 4;
            case "west":
                return Math.PI;
            case "northwest":
                return 3 * Math.PI / 4;
            default:
                return null;
            }
        }

        
        function calculateEndpoint(x, y, length, bearing) {
            const endpointX = x + length * Math.cos(bearing);
            const endpointY = y - length * Math.sin(bearing);
            return { x: endpointX, y: endpointY };
        }

        
        function drawArrow(ctx, x1, y1, x2, y2) {
            
            const angle = Math.atan2(y2 - y1, x2 - x1);

            
            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.stroke();

            
            ctx.beginPath();
            ctx.moveTo(x2, y2);
            ctx.lineTo(x2 - 10 * Math.cos(angle - Math.PI / 6), y2 - 10 * Math.sin(angle - Math.PI / 6));
            ctx.lineTo(x2 - 10 * Math.cos(angle + Math.PI / 6), y2 - 10 * Math.sin(angle + Math.PI / 6));
            ctx.closePath();
            ctx.fill();
        }

        function drawRoute() {
            
            const direction = document.getElementById("direction").value;
            const length = parseFloat(document.getElementById("length").value);
            
            

            
            const canvas = document.getElementById("map");

            
            const ctx = canvas.getContext("2d");

            
            const endpoint = calculateEndpoint(x, y, length, getBearing(direction));

            
            drawArrow(ctx, x, y, endpoint.x, endpoint.y);

            
            x = endpoint.x;
            y = endpoint.y;

            sendDataToDatabase(direction,length);
        }

        function sendDataToDatabase(d, l) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "connect.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("d=" + d + "&l=" + l);
        }
        </script>
    </body>
</html>