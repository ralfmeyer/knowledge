<div>
    <div x-data="{ leftWidth: 50, isDragging: false }" class="flex h-screen">
        <!-- Linker Bereich -->
        <div :style="{ width: leftWidth + '%' }" class="bg-blue-200 flex-shrink-0 p-4">




            Linker Bereich






        </div>

        <!-- Divider zum Ziehen -->
        <div
            @mousedown.prevent="isDragging = true"
            class="w-1 cursor-col-resize bg-gray-500"
        ></div>

        <!-- Rechter Bereich -->
        <div :style="{ width: (100 - leftWidth) + '%' }" class="bg-green-200 flex-grow p-4">
            Rechter Bereich
        </div>

        <!-- Globale Events -->
        <div
            x-init="
                window.addEventListener('mouseup', () => isDragging = false);
                window.addEventListener('mousemove', (event) => {
                    if (isDragging) {
                        let newWidth = event.clientX / window.innerWidth * 100;
                        leftWidth = Math.min(80, Math.max(20, newWidth));
                    }
                });
            "
        ></div>


    </div>




</div>
