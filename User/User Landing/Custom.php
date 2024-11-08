<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Cartoon Car Customizer</title>
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0; /* Background yang lebih cerah */
            color: #333;
        }
        #car-container {
            width: 80vw;
            height: 70vh;
            border: 5px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            overflow: hidden; /* Menghindari overflow */
        }
        .controls {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        label {
            font-size: 1.2em;
            margin-right: 10px;
        }
        select {
            margin: 0 10px;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: border-color 0.3s;
        }
        select:focus {
            outline: none;
            border-color: #66afe9;
        }
        h1 {
            margin: 20px 0;
            font-size: 2em;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>3D Cartoon Car Customizer</h1>
    <div id="car-container"></div>

    <div class="controls">
        <label for="color">Car Color:</label>
        <select id="color" onchange="changeCarColor()">
            <option value="0x0000ff">Blue</option>
            <option value="0xff0000">Red</option>
            <option value="0x00ff00">Green</option>
            <option value="0xffa500">Orange</option>
        </select>
    </div>

    <!-- Three.js dan OrbitControls dari CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

    <script>
        let scene, camera, renderer, carModel;

        // Inisialisasi Scene
        function init() {
            // Setup scene, camera, dan renderer
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0xaaaaaa); // Warna background abu-abu
            
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 1, 5);  // Posisi kamera yang nyaman untuk mobil

            renderer = new THREE.WebGLRenderer({ antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight * 0.7);
            document.getElementById('car-container').appendChild(renderer.domElement);

            // Tambahkan pencahayaan yang cukup
            const ambientLight = new THREE.AmbientLight(0xffffff, 1); // Ambient light dengan intensitas tinggi
            scene.add(ambientLight);

            const directionalLight = new THREE.DirectionalLight(0xffffff, 2); // Directional light dengan intensitas tinggi
            directionalLight.position.set(5, 5, 5);
            scene.add(directionalLight);

            // Muat model `cartoon_car.glb`
            const loader = new THREE.GLTFLoader();
            loader.load('cartoon_car.glb', function (gltf) {
                carModel = gltf.scene;

                // Memuat tekstur
                const textureLoader = new THREE.TextureLoader();

                // Carbon Fiber Textures
                const carbonFiberBaseColor = textureLoader.load('carbon_fiber_basecolor.jpg');
                const carbonFiberMetallic = textureLoader.load('carbon_fiber_metallic.jpg');
                const carbonFiberRoughness = textureLoader.load('carbon_fiber_roughness.jpg');
                const carbonFiberNormal = textureLoader.load('carbon_fiber_normal.jpg');

                // Intercooler Texture
                const intercoolerNormal = textureLoader.load('intercooler_normal.jpg');

                // Lights Textures
                const lightsBaseColor = textureLoader.load('lights_basecolor.jpg');
                const lightsNormal = textureLoader.load('lights_normal.jpg');

                // Wheel Textures
                const wheelBaseColor = textureLoader.load('wheel_basecolor.jpg');
                const wheelMetallic = textureLoader.load('wheel_metallic.jpg');
                const wheelRoughness = textureLoader.load('wheel_roughness.jpg');
                const wheelNormal = textureLoader.load('wheel_normal.jpg');

                // Terapkan tekstur pada material mobil
                carModel.traverse((child) => {
                    if (child.isMesh) {
                        if (child.material.name === "Window") {
                            // Material jendela tetap
                            child.material = new THREE.MeshStandardMaterial({ color: 0x000000, transparent: true, opacity: 0.5 });
                        } else if (child.material.name === "CarbonFiber") {
                            // Terapkan tekstur karbon fiber
                            child.material = new THREE.MeshStandardMaterial({
                                map: carbonFiberBaseColor,
                                metalnessMap: carbonFiberMetallic,
                                roughnessMap: carbonFiberRoughness,
                                normalMap: carbonFiberNormal,
                            });
                        } else if (child.material.name === "Intercooler") {
                            // Terapkan tekstur intercooler
                            child.material = new THREE.MeshStandardMaterial({
                                normalMap: intercoolerNormal,
                            });
                        } else if (child.material.name === "Lights") {
                            // Terapkan tekstur lampu
                            child.material = new THREE.MeshStandardMaterial({
                                map: lightsBaseColor,
                                normalMap: lightsNormal,
                            });
                        } else if (child.material.name === "Wheel") {
                            // Terapkan tekstur roda
                            child.material = new THREE.MeshStandardMaterial({
                                map: wheelBaseColor,
                                metalnessMap: wheelMetallic,
                                roughnessMap: wheelRoughness,
                                normalMap: wheelNormal,
                            });
                        }
                    }
                });

                carModel.scale.set(1.5, 1.5, 1.5);  // Sesuaikan ukuran model
                scene.add(carModel);
            }, undefined, function (error) {
                console.error("Error loading model:", error);
            });

            // Kontrol orbit agar bisa diputar
            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;

            // Render loop
            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
            animate();
        }

        // Fungsi untuk mengubah warna mobil
        function changeCarColor() {
            const color = document.getElementById("color").value;
            if (carModel) {
                carModel.traverse((child) => {
                    if (child.isMesh && child.material.name !== "Window") {
                        child.material.color.setHex(color);
                    }
                });
            }
        }

        // Panggil fungsi init untuk memulai
        init();
    </script>

</body>
</html>
