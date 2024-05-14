<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Cake</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #F4F4F4; /* Light gray background color */
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .options-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .option {
            cursor: pointer;
            margin: 5px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }
        .option:hover {
            border-color: #333;
        }
        .plate-option {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            background-size: cover;
            background-position: center;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }
        .plate-option:hover {
            border-color: #333;
        }
        .color-options-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        .color-option {
            cursor: pointer;
            margin: 5px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid transparent;
            transition: border-color 0.3s ease;
        }
        .color-option:hover {
            border-color: #333;
        }
        .add-layer-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .add-layer-btn:hover {
            background-color: #45a049;
        }
        #saveBtn {
            background-color: #008CBA;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        #saveBtn:hover {
            background-color: #005f76;
        }
        .remove-age-btn {
            background-color: #FF0000;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .remove-age-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Customization</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
        }
        .options-container {
            margin-bottom: 20px;
        }
        .color-container {
            text-align: center;
        }
        .option.color-option {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }
        .color-title {
            font-weight: bold;
            margin-top: 5px;
        }
        .blue-title {
            color: blue;
        }
        .pink-title {
            color: pink;
        }
        .chocolate-title {
            color: chocolate;
        }
        .purple-title {
            color: purple;
        }
        .cream-title {
            color: #FFFFCC;
        }
    </style>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <title>Customize Your Cake</title>
    <style>
        /* Button Style */
        .add-layer-btn,
        .remove-layer-btn,
        .remove-btn,
        .upload-btn,
        .save-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Positioning the Upload button */
        .save-btn,
        .upload-btn {
            float: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Customize Your Cake</h1>
        <div class="options-container">
            <div id="color-options" style="display: flex;">
                <div class="color-container" style="margin-right: 5px;">
                    <div class="option color-option" style="background-color: blue;" onclick="changeColor('cake', 0)"></div> <!-- Blue -->
                    <div class="color-title blue-title">(Blue Icing)</div>
                </div>
                <div class="color-container" style="margin-right: 5px;">
                    <div class="option color-option" style="background-color: pink;" onclick="changeColor('cake', 2)"></div> <!-- Pink -->
                    <div class="color-title pink-title">(Strawberry)</div>
                </div>
                <div class="color-container" style="margin-right: 5px;">
                    <div class="option color-option" style="background-color: chocolate;" onclick="changeColor('cake', 4)"></div> <!-- Chocolate -->
                    <div class="color-title chocolate-title">(Chocolate)</div>
                </div>
                <div class="color-container" style="margin-right: 5px;">
                    <div class="option color-option" style="background-color: purple;" onclick="changeColor('cake', 5)"></div> <!-- Purple -->
                    <div class="color-title purple-title">(Ube)</div>
                </div>
                <div class="color-container" style="margin-right: 5px;">
                    <div class="option color-option" style="background-color: #FFFFCC;" onclick="changeColor('cake', 6)"></div> <!-- Cream -->
                    <div class="color-title cream-title">(Plain)</div>
                </div>
            </div>
        </div>
        <div class="options-container">
            <input type="number" id="ageInput" placeholder="Enter your age">
            <button class="add-layer-btn" onclick="addAgeNumber()">Add Age Number</button>
            <button class="remove-age-btn" onclick="removeAgeNumber()">Remove Age Number</button>
        </div>
        <div class="options-container">
            <button class="add-layer-btn" onclick="toggleCherry()">Put Cherry</button>
            <button class="add-layer-btn" onclick="removeCherry()">Remove Cherry</button>
            <button class="add-layer-btn" onclick="toggleSprinkles()">Put Sprinkles</button>
            <button class="add-layer-btn" onclick="removeSprinkles()">Remove Sprinkles</button>
        </div>
        <div class="options-container">
            <button class="add-layer-btn" onclick="toggleChocolates()">Add Chocolates</button>
            <button class="remove-btn" onclick="removeChocolates()"><span><i class="fa fa-ban fa-lg" aria-hidden="true"></i></span></button>
            <button class="add-layer-btn" onclick="toggleStrawberries()">Add Strawberries</button>
            <button class="remove-btn" onclick="removeStrawberries()"><span><i class="fa fa-ban fa-lg" aria-hidden="true"></i></span></button>
            <button class="add-layer-btn" onclick="toggleBlueberries()">Add Blueberries</button>
            <button class="remove-btn" onclick="removeBlueberries()"><span><i class="fa fa-ban fa-lg" aria-hidden="true"></i></span></button>
        </div>
        <div class="options-container">
            <button class="add-layer-btn" onclick="toggleCheese()">Add Cheese</button>
            <button class="remove-layer-btn" onclick="removeCheese()"><span><i class="fa fa-ban fa-lg" aria-hidden="true"></i></span></button>
            <button class="add-layer-btn" onclick="toggleChocolateSticks()">Chocolate Sticks</button>
            <button class="remove-layer-btn" onclick="removeChocolateSticks()"><span><i class="fa fa-ban fa-lg" aria-hidden="true"></i></span></button>
        </div>
        <div class="options-container">
            <input type="text" id="messageInput" placeholder="Short Message">
            <select id="textColorSelect">
                <option value="blue">Blue</option>
                <option value="pink">Pink</option>
                <option value="white">White</option>
                <option value="red">Red</option>
                <option value="darkbrown">Dark Brown</option>
            </select>
            <button class="add-layer-btn" onclick="addTextMessage()">Add Short Message</button>
            <button class="remove-age-btn" onclick="removeTextMessage()">Remove Short Message</button>
        </div>
        <div class="options-container">
        <button class="save-btn" onclick="saveImage()">Save</button> <!-- Save button added -->
        <button class="upload-btn" onclick="window.location.href = 'upload_cake.php'">Upload your Customized Cake</button> <!-- Upload button added -->
    </div>
</body>
</html>



    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        var cakeColor = 0xFFFFCC; // Default cake color: Cream
        var plateColor = 0xB0C4DE; // Default plate color: Light steel blue
        var cherryVisible = false; // Flag to track cherry visibility
        var sprinklesVisible = false; // Flag to track sprinkles visibility
        var chocolatesVisible = false; // Flag to track chocolates visibility
        var strawberriesVisible = false; // Flag to track strawberries visibility
        var blueberriesVisible = false; // Flag to track blueberries visibility
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, .1, 1000);
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        const cakeGeometry = new THREE.CylinderGeometry(4, 4, 4, 25); // Adjusted cake geometry
        const cakeMaterial = new THREE.MeshPhongMaterial({ color: cakeColor }); // Changed material to Phong
        const cake = new THREE.Mesh(cakeGeometry, cakeMaterial);
        scene.add(cake);

        const plateGeometry = new THREE.CircleGeometry(5, 35); // Adjusted plate geometry
        const plateMaterial = new THREE.MeshPhongMaterial({ color: plateColor }); // Changed material to Phong
        const plate = new THREE.Mesh(plateGeometry, plateMaterial);
        plate.rotation.x = -Math.PI / 2;
        plate.position.y = -2; // Adjusted plate position
        scene.add(plate);

        var cheeseVisible = false; // Flag to track cheese visibility

function toggleCheese() {
    if (cheeseVisible) {
        removeCheese();
    } else {
        addCheese();
    }
    cheeseVisible = !cheeseVisible;
}

function addCheese() {
    const numCheese = 1500; // Increase the number of cheese particles
    const cheeseColors = [0xFFFF00]; // Yellow cheese color

    for (let i = 0; i < numCheese; i++) {
        const cheeseGeometry = new THREE.BoxGeometry(0.10, 0.15, 1); // Adjust size for cheese particles
        const cheeseMaterial = new THREE.MeshPhongMaterial({
            color: cheeseColors[Math.floor(Math.random() * cheeseColors.length)],
            side: THREE.DoubleSide,
            transparent: true,
            opacity: 0.9 + Math.random() * 0.1 // Adjust opacity for visibility
        });

        const cheese = new THREE.Mesh(cheeseGeometry, cheeseMaterial);

        // Spread the cheese evenly on the top of the cake
        const radius = 3.5; // Adjust radius to control spread
        const angle = Math.random() * Math.PI * 2;
        const spreadRadius = Math.sqrt(Math.random()) * radius; // Randomize spread radius for a more natural look
        const x = Math.cos(angle) * spreadRadius;
        const z = Math.sin(angle) * spreadRadius;
        const y = 2 + Math.random() * 0.1; // Ensure cheese is slightly above the cake surface
        cheese.position.set(x, y, z);

        // Rotate cheese randomly to add variation
        cheese.rotation.z = Math.random() * Math.PI * 2;
        cheese.rotation.y = Math.random() * Math.PI * 2;

        scene.add(cheese);
    }
}

function removeCheese() {
    scene.children.forEach(child => {
        if (child.geometry instanceof THREE.BoxGeometry &&
            child.geometry.parameters.width === 0.10 &&
            child.geometry.parameters.height === 0.15 &&
            child.geometry.parameters.depth === 1) {
            scene.remove(child);
        }
    });
}

var chocolateSticksVisible = false; // Flag to track chocolate sticks visibility

function toggleChocolateSticks() {
    if (chocolateSticksVisible) {
        removeChocolateSticks();
    } else {
        addChocolateSticks();
    }
    chocolateSticksVisible = !chocolateSticksVisible;
}

function addChocolateSticks() {
    const numSticks = 4; // Number of chocolate sticks
    const stickGeometry = new THREE.CylinderGeometry(0.1, 0.1, 5, 10); // Adjusted geometry for sticks
    const stickMaterial = new THREE.MeshPhongMaterial({ color: 0x8B4513 }); // Brown color for sticks

    for (let i = 0; i < numSticks; i++) {
        const stick = new THREE.Mesh(stickGeometry, stickMaterial);

        // Position the sticks around the cake
        const angle = (i / numSticks) * Math.PI * 2;
        const x = Math.cos(angle) * 3.5; // Adjust radius to position sticks farther away from the center
        const z = Math.sin(angle) * 3.5; // Adjust radius to position sticks farther away from the center
        stick.position.set(x, 1.5, z); // Adjust y-position for sticks

        scene.add(stick);
    }
}

function removeChocolateSticks() {
    scene.children.forEach(child => {
        if (child.geometry instanceof THREE.CylinderGeometry && child.geometry.parameters.height === 3) {
            scene.remove(child);
        }
    });
}



        camera.position.z = 10; // Adjusted camera position

        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);
        const pointLight = new THREE.PointLight(0xffffff, 1);
        pointLight.position.set(5, 5, 5);
        scene.add(pointLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(0, 1, 0);
        scene.add(directionalLight);

        // Variables to store mouse position
        var mouseX = 0, mouseY = 0;
        var windowHalfX = window.innerWidth / 2;
        var windowHalfY = window.innerHeight / 2;
        var longPressTimeout;

        function onDocumentMouseDown(event) {
            longPressTimeout = setTimeout(function() {
                document.addEventListener('mousemove', onDocumentMouseMove, false);
            }, 500); // Adjust long press duration here
        }

        function onDocumentMouseUp(event) {
            clearTimeout(longPressTimeout);
            document.removeEventListener('mousemove', onDocumentMouseMove, false);
        }

        function onDocumentMouseMove(event) {
            mouseX = (event.clientX - windowHalfX) / 2;
            mouseY = (event.clientY - windowHalfY) / 2;
        }

        function animate() {
            requestAnimationFrame(animate);
            camera.position.x += ( mouseX - camera.position.x ) * 0.05;
            camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
            camera.lookAt( scene.position );
            renderer.render(scene, camera);
        }
        animate();

        function changeColor(target, colorIndex) {
            let newColor;
            switch (colorIndex) {
                case 0:
                    newColor = 0x0000FF; // Blue
                    break;
                case 1:
                    newColor = 0xADD8E6; // Light blue
                    break;
                case 2:
                    newColor = 0xFFC0CB; // Pink
                    break;
                case 3:
                    newColor = 0x00FF00; // Green
                    break;
                case 4:
                    newColor = 0x8B4513; // Dark chocolate
                    break;
                case 5:
                    newColor = 0x800080; // Purple
                    break;
                case 6:
                    newColor = 0xFFFFCC; // Dark red
                    break;
                case 7:
                    newColor = 0xFF0000; // Red
                    break;
                default:
                    newColor = 0xFFFFCC; // Default color: Cream
                    break;
            }
            if (target === 'cake') {
                cakeColor = newColor;
                cake.material.color.setHex(newColor);
            }
        }

        // Create cherry geometry and material
        const cherryGeometry = new THREE.SphereGeometry(0.5, 32, 32); // Reduce radius to make it smaller
        const cherryMaterial = new THREE.MeshPhongMaterial({ color: 0xFF0000 });
        const cherry = new THREE.Mesh(cherryGeometry, cherryMaterial);
        cherry.position.set(0, 2.5, 0); // Position the cherry on top of the cake

        // Create stem geometry and material
        const stemGeometry = new THREE.CylinderGeometry(0.05, 0.05, 2, 8); // Adjust height to make the stem longer
        const stemMaterial = new THREE.MeshPhongMaterial({ color: 0xFF0000 }); // Green color for stem
        const stem = new THREE.Mesh(stemGeometry, stemMaterial);
        stem.position.set(0, 3, 0); // Position the stem on top of the cherry

        function toggleCherry() {
            if (cherryVisible) {
                scene.remove(cherry);
                scene.remove(stem);
                cherryVisible = false;
            } else {
                scene.add(cherry);
                scene.add(stem);
                cherryVisible = true;
            }
        }

        function toggleSprinkles() {
            if (sprinklesVisible) {
                removeSprinkles();
            } else {
                addSprinkles();
            }
            sprinklesVisible = !sprinklesVisible;
        }

        function addSprinkles() {
            const sprinkleColors = [0xFF0000, 0xFFA500, 0xFFFF00, 0x008000, 0x0000FF, 0x4B0082, 0xEE82EE]; // Array of sprinkle colors

            for (let i = 0; i < 50; i++) { // Adding 50 sprinkles
                const sprinkleGeometry = new THREE.SphereGeometry(0.1, 8, 8);
                const randomColor = sprinkleColors[Math.floor(Math.random() * sprinkleColors.length)]; // Random color from the array
                const sprinkleMaterial = new THREE.MeshPhongMaterial({ color: randomColor });
                const sprinkle = new THREE.Mesh(sprinkleGeometry, sprinkleMaterial);
                
                // Position the sprinkle randomly on top of the cake
                sprinkle.position.x = Math.random() * 6 - 3; // Range: -3 to 3
                sprinkle.position.z = Math.random() * 6 - 3; // Range: -3 to 3
                sprinkle.position.y = 2; // Fixed y-position on top of the cake

                scene.add(sprinkle);
            }
        }

        function removeSprinkles() {
            scene.children.forEach(child => {
                if (child.geometry instanceof THREE.SphereGeometry && child.geometry.parameters.radius === 0.1) {
                    scene.remove(child);
                }
            });
        }

        function addAgeNumber() {
            const ageInput = document.getElementById('ageInput').value;
            if (ageInput === '') {
                alert('Please enter your age!');
                return;
            }
            const age = parseInt(ageInput);
            if (isNaN(age) || age <= 0) {
                alert('Please enter a valid age!');
                return;
            }

            // Remove existing age number if exists
            const existingAgeNumber = scene.getObjectByName('ageNumber');
            if (existingAgeNumber) {
                scene.remove(existingAgeNumber);
            }

            const fontLoader = new THREE.FontLoader();
            fontLoader.load('https://threejs.org/examples/fonts/helvetiker_regular.typeface.json', function(font) {
                const textGeometry = new THREE.TextGeometry(age.toString(), {
                    font: font,
                    size: 1.5,
                    height: 0.1,
                    curveSegments: 12,
                    bevelEnabled: false
                });
                const textMaterial = new THREE.MeshPhongMaterial({ color: 0xFFD700, specular: 0x111111 }); // Gold color
                const ageNumber = new THREE.Mesh(textGeometry, textMaterial);
                ageNumber.name = 'ageNumber';

                const cakeBox = new THREE.Box3().setFromObject(cake);
                const cakeCenter = new THREE.Vector3();
                cakeBox.getCenter(cakeCenter);
                ageNumber.position.copy(cakeCenter);
                ageNumber.position.y = cakeBox.max.y + 1; // Positioning at the top of the cake

                scene.add(ageNumber);

                // Position the age number slightly left
                ageNumber.position.x -= 1; // Adjust position slightly left
                ageNumber.position.y -= 1; // Adjust position slightly left
            });
        }

        function removeAgeNumber() {
            const existingAgeNumber = scene.getObjectByName('ageNumber');
            if (existingAgeNumber) {
                scene.remove(existingAgeNumber);
            }
        }
        function addTextMessage() {
    const messageInput = document.getElementById('messageInput').value;
    if (messageInput === '') {
        alert('Please enter your message!');
        return;
    }

    const textColorSelect = document.getElementById('textColorSelect');
    const selectedColor = textColorSelect.value;

    // Remove existing text message if exists
    const existingTextMessage = scene.getObjectByName('textMessage');
    if (existingTextMessage) {
        scene.remove(existingTextMessage);
    }

    const fontLoader = new THREE.FontLoader();
    fontLoader.load('https://threejs.org/examples/fonts/helvetiker_regular.typeface.json', function(font) {
        // Create text geometry
        const textGeometry = new THREE.TextGeometry(messageInput, {
            font: font,
            size: 0.5, // Adjust size based on your preference
            height: 0.2, // Adjust height based on your preference
            curveSegments: 12,
            bevelEnabled: false
        });

        // Rotate text to make it horizontal
        textGeometry.rotateX(-Math.PI / 2);

        let textColor;
switch (selectedColor) {
    case 'blue':
        textColor = 0x0000FF; // Blue
        break;
    case 'pink':
        textColor = 0xFFC0CB; // Pink
        break;
    case 'white':
        textColor = 0xFFFFFF; // White
        break;
    case 'darkbrown':
        textColor = 0x654321; // Dark Brown
        break;
    case 'red':
        textColor = 0xFF0000; // Red
        break;
    default:
        textColor = 0x654321; // Default to Dark Brown
        break;
}


        const textMaterial = new THREE.MeshPhongMaterial({ color: textColor });
        const textMessage = new THREE.Mesh(textGeometry, textMaterial);
        textMessage.name = 'textMessage';

        const cakeBox = new THREE.Box3().setFromObject(cake);
        const cakeCenter = new THREE.Vector3();
        cakeBox.getCenter(cakeCenter);

        // Position the text message
        textMessage.position.copy(cakeCenter);
        textMessage.position.y = cakeBox.max.y + 0.1; // Adjust height based on your preference
        textMessage.position.x -= 2.5; // Move text slightly to the left

        scene.add(textMessage);
    });
}








        function toggleChocolates() {
            if (chocolatesVisible) {
                removeChocolates();
            } else {
                addChocolates();
            }
            chocolatesVisible = !chocolatesVisible;
        }

        function addChocolates() {
            const numChocolates = 20; // Number of chocolates to add
            const chocolateShapes = [
                new THREE.BoxGeometry(0.5, 0.3, 1), // Rectangular chocolate
                new THREE.SphereGeometry(0.3, 8, 8), // Circular chocolate
                new THREE.ConeGeometry(0.3, 0.5, 8) // Conical chocolate
            ];
            const chocolateColors = [0x3E2723]; // Dark chocolate colors
            const outerRadius = 3.5; // Adjust the radius to position chocolates farther away from the center

            for (let i = 0; i < numChocolates; i++) {
                const randomShapeIndex = Math.floor(Math.random() * chocolateShapes.length);
                const randomColor = chocolateColors[Math.floor(Math.random() * chocolateColors.length)];
                const chocolate = new THREE.Mesh(chocolateShapes[randomShapeIndex], new THREE.MeshPhongMaterial({ color: randomColor }));

                // Position the chocolate on top of the cake and spread them evenly on the outer area
                const angle = (i / numChocolates) * Math.PI * 2;
                const x = Math.cos(angle) * outerRadius;
                const z = Math.sin(angle) * outerRadius;
                const y = 2 + Math.random() * 0.3; // Randomize y position slightly
                chocolate.position.set(x, y, z);

                scene.add(chocolate);
            }
        }

        function removeChocolates() {
            scene.children.forEach(child => {
                if (child.geometry instanceof THREE.BoxGeometry ||
                    child.geometry instanceof THREE.SphereGeometry ||
                    child.geometry instanceof THREE.ConeGeometry) {
                    scene.remove(child);
                }
            });
        }

        function toggleStrawberries() {
            if (strawberriesVisible) {
                removeStrawberries();
            } else {
                addStrawberries();
            }
            strawberriesVisible = !strawberriesVisible;
        }

        function addStrawberries() {
            const numStrawberries = 10; // Number of strawberries to add
            const strawberryGeometry = new THREE.SphereGeometry(0.4, 32, 32); // Adjust radius for strawberries
            const strawberryMaterial = new THREE.MeshPhongMaterial({ color: 0xFF0000 }); // Red color for strawberries
            const outerRadius = 3.5; // Adjust the radius to position strawberries farther away from the center

            for (let i = 0; i < numStrawberries; i++) {
                const strawberry = new THREE.Mesh(strawberryGeometry, strawberryMaterial);

                // Position the strawberry on top of the cake and spread them evenly on the outer area
                const angle = (i / numStrawberries) * Math.PI * 2;
                const x = Math.cos(angle) * outerRadius;
                const z = Math.sin(angle) * outerRadius;
                const y = 2 + Math.random() * 0.3; // Randomize y position slightly
                strawberry.position.set(x, y, z);

                scene.add(strawberry);
            }
        }

        function removeStrawberries() {
            scene.children.forEach(child => {
                if (child.geometry instanceof THREE.SphereGeometry && child.geometry.parameters.radius === 0.4) {
                    scene.remove(child);
                }
            });
        }
        
        function toggleBlueberries() {
            if (blueberriesVisible) {
                removeBlueberries();
            } else {
                addBlueberries();
            }
            blueberriesVisible = !blueberriesVisible;
        }

        function addBlueberries() {
            const numBlueberries = 15; // Number of blueberries to add
            const blueberryGeometry = new THREE.SphereGeometry(0.2, 32, 32); // Adjust radius for blueberries
            const blueberryMaterial = new THREE.MeshPhongMaterial({ color: 0x000080 }); // Blue color for blueberries
            const outerRadius = 3.5; // Adjust the radius to position blueberries farther away from the center

            for (let i = 0; i < numBlueberries; i++) {
                const blueberry = new THREE.Mesh(blueberryGeometry, blueberryMaterial);

                // Position the blueberry on top of the cake and spread them evenly on the outer area
                const angle = (i / numBlueberries) * Math.PI * 2;
                const x = Math.cos(angle) * outerRadius;
                const z = Math.sin(angle) * outerRadius;
                const y = 2 + Math.random() * 0.3; // Randomize y position slightly
                blueberry.position.set(x, y, z);

                scene.add(blueberry);
            }
        }

        function removeBlueberries() {
            scene.children.forEach(child => {
                if (child.geometry instanceof THREE.SphereGeometry && child.geometry.parameters.radius === 0.2) {
                    scene.remove(child);
                }
            });
        }

        // Function to handle save button click
function saveImage() {
    // Set the renderer size to match the current window size for rendering
    renderer.setSize(window.innerWidth, window.innerHeight);

    // Render the scene from the current camera perspective
    renderer.render(scene, camera);

    // Convert the rendered scene to an image
    const image = renderer.domElement.toDataURL("image/png");

    // Create a download link for the image
    const link = document.createElement('a');
    link.href = image;
    link.download = 'cake_image.png'; // You can change the filename as needed
    link.click();
}
document.addEventListener('mousedown', onDocumentMouseDown, false);
document.addEventListener('mouseup', onDocumentMouseUp, false);

function onDocumentMouseDown(event) {
    longPressTimeout = setTimeout(function() {
        document.addEventListener('mousemove', onDocumentMouseMove, false);
    }, 500); // Adjust long press duration here
}

function onDocumentMouseUp(event) {
    clearTimeout(longPressTimeout);
    document.removeEventListener('mousemove', onDocumentMouseMove, false);
}

function onDocumentMouseMove(event) {
    mouseX = (event.clientX - windowHalfX) / 2;
    mouseY = (event.clientY - windowHalfY) / 2;
}
function animate() {
    requestAnimationFrame(animate);
    camera.position.x += ( mouseX - camera.position.x ) * 0.05;
    camera.position.y += ( - mouseY - camera.position.y ) * 0.05;
    camera.lookAt( scene.position );
    renderer.render(scene, camera);
}


        
    </script>
</body>
</html>
