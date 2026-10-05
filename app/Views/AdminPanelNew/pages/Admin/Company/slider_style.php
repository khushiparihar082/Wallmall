<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swiper Slider</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .customization-form {
            margin-bottom: 20px;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            /* Allow items to wrap */
            gap: 10px;
            /* Adjust gap between images */
        }

        .swiper-slide img {
            max-width: calc(33.33% - 20px);
            /* Adjust width of each image */
            height: auto;
            margin-bottom: 10px;
            /* Adjust margin between images */
        }
    </style>
</head>

<body>
    <div class="customization-form">
        <h3>Customize Your Slider</h3>
        <form id="sliderForm">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-3 mb-3">
                        <label for="loop">Loop:</label><br>
                        <input type="radio" id="loopTrue" name="loop" value="true" checked>
                        <label for="loopTrue">True</label><br>
                        <input type="radio" id="loopFalse" name="loop" value="false">
                        <label for="loopFalse">False</label><br>
                    </div>
                    
                    <div class="form-group col-md-3 mb-3">
                        <label for="pagination">Pagination:</label><br>
                        <input type="radio" id="paginationTrue" name="pagination" value="true" checked>
                        <label for="paginationTrue">True</label><br>
                        <input type="radio" id="paginationFalse" name="pagination" value="false">
                        <label for="paginationFalse">False</label><br>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="autoplayDelay">Autoplay Delay (ms):</label><br>
                        <input type="number" id="autoplayDelay" name="autoplayDelay" value="2000" min="0" step="100">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="centerInsufficientSlides">Center Insufficient Slides:</label><br>
                        <select id="centerInsufficientSlides" name="centerInsufficientSlides">
                            <option value="false">False</option>
                            <option value="true">True</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="centeredSlides">Centered Slides:</label><br>
                        <select id="centeredSlides" name="centeredSlides">
                            <option value="false">False</option>
                            <option value="true">True</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="centeredSlidesBounds">Centered Slides Bounds:</label><br>
                        <select id="centeredSlidesBounds" name="centeredSlidesBounds">
                            <option value="false">False</option>
                            <option value="true">True</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="applyCubeEffect">Apply Cube Effect:</label><br>
                        <input type="checkbox" id="applyCubeEffect" name="applyCubeEffect">
                    </div>
                    <div class="form-group col-md-3 mb-3">
                        <label for="applyFlipEffect">Apply Flip Effect:</label><br>
                        <input type="checkbox" id="applyFlipEffect" name="applyFlipEffect">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="updateSlider()">Update Slider</button>
        </form>
    </div>

    <!-- First Swiper -->
    <div class="swiper-container swiper-container-1">
        <div class="swiper-wrapper">
            <!-- Slides for the first swiper -->
            <div class="swiper-slide"><img src="https://as2.ftcdn.net/v2/jpg/01/67/25/37/1000_F_167253732_FVaF7PyA5vat3JVPvP4F5AsCoZkYAnZF.jpg" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="https://as1.ftcdn.net/v2/jpg/07/12/56/04/1000_F_712560448_dhocrac1x5wuJ18AgpK1KHyCBJtoDyFb.jpg" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="https://c4.wallpaperflare.com/wallpaper/81/232/976/tamannaah-traditional-4k-saree-wallpaper-preview.jpg" alt="Slide 3"></div>
        </div>
        <div class="swiper-pagination swiper-pagination-1"></div>
        <div class="swiper-button-prev swiper-button-prev-1"></div>
        <div class="swiper-button-next swiper-button-next-1"></div>
    </div>

    <!-- Second Swiper -->
    <div class="swiper-container swiper-container-2">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="https://as2.ftcdn.net/v2/jpg/01/67/25/37/1000_F_167253732_FVaF7PyA5vat3JVPvP4F5AsCoZkYAnZF.jpg" alt="Slide 1">
                <img src="https://as1.ftcdn.net/v2/jpg/07/12/56/04/1000_F_712560448_dhocrac1x5wuJ18AgpK1KHyCBJtoDyFb.jpg" alt="Slide 2">
                <img src="https://c4.wallpaperflare.com/wallpaper/81/232/976/tamannaah-traditional-4k-saree-wallpaper-preview.jpg" alt="Slide 3">
            </div>
            <div class="swiper-slide">
                <img src="https://as2.ftcdn.net/v2/jpg/01/67/25/37/1000_F_167253732_FVaF7PyA5vat3JVPvP4F5AsCoZkYAnZF.jpg" alt="Slide 4">
                <img src="https://as1.ftcdn.net/v2/jpg/07/12/56/04/1000_F_712560448_dhocrac1x5wuJ18AgpK1KHyCBJtoDyFb.jpg" alt="Slide 5">
                <img src="https://c4.wallpaperflare.com/wallpaper/81/232/976/tamannaah-traditional-4k-saree-wallpaper-preview.jpg" alt="Slide 6">
            </div>
            <div class="swiper-slide">
                <img src="https://as2.ftcdn.net/v2/jpg/01/67/25/37/1000_F_167253732_FVaF7PyA5vat3JVPvP4F5AsCoZkYAnZF.jpg" alt="Slide 1">
                <img src="https://as1.ftcdn.net/v2/jpg/07/12/56/04/1000_F_712560448_dhocrac1x5wuJ18AgpK1KHyCBJtoDyFb.jpg" alt="Slide 2">
                <img src="https://c4.wallpaperflare.com/wallpaper/81/232/976/tamannaah-traditional-4k-saree-wallpaper-preview.jpg" alt="Slide 3">
            </div>
            <div class="swiper-slide">
                <img src="https://as2.ftcdn.net/v2/jpg/01/67/25/37/1000_F_167253732_FVaF7PyA5vat3JVPvP4F5AsCoZkYAnZF.jpg" alt="Slide 4">
                <img src="https://as1.ftcdn.net/v2/jpg/07/12/56/04/1000_F_712560448_dhocrac1x5wuJ18AgpK1KHyCBJtoDyFb.jpg" alt="Slide 5">
                <img src="https://c4.wallpaperflare.com/wallpaper/81/232/976/tamannaah-traditional-4k-saree-wallpaper-preview.jpg" alt="Slide 6">
            </div>
        </div>
        <div class="swiper-pagination swiper-pagination-2"></div>
        <div class="swiper-button-prev swiper-button-prev-2"></div>
        <div class="swiper-button-next swiper-button-next-2"></div>
        <div class="swiper-scrollbar"></div> <!-- If needed -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        
        // Initialize first Swiper instance
    function initializeSwiper(containerSelector, {
    effect = 'flip',
    flipEffect = { slideShadows: false },
    loop = true,
    autoplay = { delay: 2000 },
    autoHeight = true,
    pagination = { el: `${containerSelector} .swiper-pagination`, clickable: true },
    navigation = { nextEl: `${containerSelector} .swiper-button-next`, prevEl: `${containerSelector} .swiper-button-prev` },
    centerInsufficientSlides = false,
    centeredSlides = false,
    centeredSlidesBounds = false,
    slidesPerView = 1,
    spaceBetween = 0,
    cubeEffect = { slideShadows: true, shadow: true, shadowOffset: 20, shadowScale: 0.94 },
} = {}) {
    let swiperOptions = {
        effect,
        flipEffect,
        loop,
        autoplay,
        autoHeight,
        pagination,
        navigation,
        centerInsufficientSlides,
        centeredSlides,
        centeredSlidesBounds,
        slidesPerView,
        spaceBetween,
        cubeEffect,
    };

    return new Swiper(containerSelector, swiperOptions);
}

        function updateSlider() {
            const loop = document.querySelector('input[name="loop"]:checked').value === 'true';
            const pagination = document.querySelector('input[name="pagination"]:checked').value === 'true';
            const autoplayDelay = parseInt(document.getElementById('autoplayDelay').value, 10);
            const centerInsufficientSlides = document.getElementById('centerInsufficientSlides').value === 'true';
            const centeredSlides = document.getElementById('centeredSlides').value === 'true';
            const centeredSlidesBounds = document.getElementById('centeredSlidesBounds').value === 'true';

            swiper1.params.loop = loop;
            swiper1.params.autoplay.delay = autoplayDelay;
            swiper2.params.loop = loop;
            swiper2.params.autoplay.delay = autoplayDelay;

            if (pagination) {
                swiper1.pagination.el.style.display = 'block';
                swiper1.pagination.update();
                swiper2.pagination.el.style.display = 'block';
                swiper2.pagination.update();
            } else {
                swiper1.pagination.el.style.display = 'none';
                swiper2.pagination.el.style.display = 'none';
            }

            // Apply new parameters
            swiper1.params.centerInsufficientSlides = centerInsufficientSlides;
            swiper1.params.centeredSlides = centeredSlides;
            swiper1.params.centeredSlidesBounds = centeredSlidesBounds;

            swiper2.params.centerInsufficientSlides = centerInsufficientSlides;
            swiper2.params.centeredSlides = centeredSlides;
            swiper2.params.centeredSlidesBounds = centeredSlidesBounds;

            // Check if cube effect should be applied
            const applyCubeEffect = document.getElementById('applyCubeEffect').checked;
            const applyFlipEffect = document.getElementById('applyFlipEffect').checked;

            if (applyCubeEffect) {
                swiper1.params.effect = 'cube';
                swiper1.params.cubeEffect = {
                    slideShadows: false,
                };
                swiper2.params.effect = 'cube';
                swiper2.params.cubeEffect = {
                    slideShadows: false,
                };
            } else if (applyFlipEffect) {
                swiper1.params.effect = 'flip';
                swiper1.params.flipEffect = {
                    slideShadows: false,
                };
                swiper2.params.effect = 'flip';
                swiper2.params.flipEffect = {
                    slideShadows: false,
                };
            } else {
                swiper1.params.effect = 'slide'; // Default to slide if neither is checked
                swiper1.params.flipEffect = null;
                swiper1.params.cubeEffect = null;
                swiper2.params.effect = 'slide'; // Default to slide if neither is checked
                swiper2.params.flipEffect = null;
                swiper2.params.cubeEffect = null;
            }

            swiper1.update();
            swiper1.slideToLoop(0);
            swiper1.autoplay.start();

            swiper2.update();
            swiper2.slideToLoop(0);
            swiper2.autoplay.start();
        }
    </script>
</body>

</html>