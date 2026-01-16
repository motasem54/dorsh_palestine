<?php
$page_title = "Products - Dorsch Palestine";
include 'header.php';
?>

<!-- Breadcrumb -->
<section class="breadcrumb-section" style="background: linear-gradient(135deg, #4A90E2 0%, #66A3E8 100%); padding: 60px 0; margin-top: 140px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content text-center">
                    <h1 style="color: #fff; font-size: 48px; font-weight: 700; margin-bottom: 15px;">Our Products</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center" style="background: transparent; margin: 0; padding: 0;">
                            <li class="breadcrumb-item"><a href="index.php" style="color: #fff; text-decoration: none;">Home</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section" style="padding: 100px 0; background: #fff;">
    <div class="container-fluid" style="max-width: 1400px;">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4">
                <div class="filters-sidebar" style="position: sticky; top: 160px;">
                    <!-- Search Filter -->
                    <div class="filter-box" style="background: #f8f8f8; padding: 25px; border-radius: 15px; margin-bottom: 20px;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-search" style="color: #4A90E2;"></i>
                            Search Products
                        </h4>
                        <div style="position: relative;">
                            <input type="text" id="searchProduct" placeholder="Search..." style="width: 100%; padding: 12px 40px 12px 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; outline: none;">
                            <i class="fas fa-search" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                        </div>
                    </div>

                    <!-- Categories Filter -->
                    <div class="filter-box" style="background: #f8f8f8; padding: 25px; border-radius: 15px; margin-bottom: 20px;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-th-large" style="color: #4A90E2;"></i>
                            Categories
                        </h4>
                        <ul class="category-list" style="list-style: none; padding: 0; margin: 0;">
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="all" checked style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">All Products</span>
                                <span style="margin-left: auto; color: #4A90E2; font-weight: 600; font-size: 13px;">(48)</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="cookware" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Cookware</span>
                                <span style="margin-left: auto; color: #4A90E2; font-weight: 600; font-size: 13px;">(15)</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="bakeware" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Bakeware</span>
                                <span style="margin-left: auto; color: #4A90E2; font-weight: 600; font-size: 13px;">(12)</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="cutlery" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Cutlery Sets</span>
                                <span style="margin-left: auto; color: #4A90E2; font-weight: 600; font-size: 13px;">(8)</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="coffee-tea" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Coffee & Tea</span>
                                <span style="margin-left: auto; color: #4A90E2; font-weight: 600; font-size: 13px;">(7)</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="knives" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Knives</span>
                                <span style="margin-left: auto; color: #4A90E2; font-weight: 600; font-size: 13px;">(6)</span>
                            </label></li>
                        </ul>
                    </div>

                    <!-- Collections Filter -->
                    <div class="filter-box" style="background: #f8f8f8; padding: 25px; border-radius: 15px; margin-bottom: 20px;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-star" style="color: #4A90E2;"></i>
                            Collections
                        </h4>
                        <ul class="collection-list" style="list-style: none; padding: 0; margin: 0;">
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="lifetime" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Lifetime Series</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="premium" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">Premium</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="gopress" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">GoPress</span>
                            </label></li>
                            <li><label style="display: flex; align-items: center; padding: 10px; cursor: pointer; transition: all 0.3s ease; border-radius: 8px;">
                                <input type="checkbox" value="steelpro" style="margin-right: 12px; width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 15px; color: #666;">SteelPro</span>
                            </label></li>
                        </ul>
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-box" style="background: #f8f8f8; padding: 25px; border-radius: 15px; margin-bottom: 20px;">
                        <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-dollar-sign" style="color: #4A90E2;"></i>
                            Price Range
                        </h4>
                        <div style="margin-bottom: 15px;">
                            <input type="range" min="0" max="500" value="500" id="priceRange" style="width: 100%;">
                            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                                <span style="font-size: 14px; color: #666;">$0</span>
                                <span style="font-size: 14px; color: #4A90E2; font-weight: 600;" id="priceValue">$500</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reset Filters -->
                    <button onclick="resetFilters()" style="width: 100%; background: transparent; border: 2px solid #4A90E2; color: #4A90E2; padding: 14px; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;">
                        <i class="fas fa-redo" style="margin-right: 8px;"></i>Reset Filters
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <!-- Toolbar -->
                <div class="products-toolbar" style="background: #f8f8f8; padding: 20px 25px; border-radius: 15px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div class="results-count">
                        <span style="font-size: 15px; color: #666;">Showing <strong style="color: #1a1a1a;" id="productCount">48</strong> products</span>
                    </div>
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <select id="sortBy" style="padding: 10px 35px 10px 15px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; outline: none; cursor: pointer; background: #fff;">
                            <option value="default">Default Sorting</option>
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="price-asc">Price (Low to High)</option>
                            <option value="price-desc">Price (High to Low)</option>
                            <option value="newest">Newest First</option>
                        </select>

                        <div class="view-mode" style="display: flex; gap: 8px;">
                            <button class="view-grid active" onclick="changeView('grid')" style="width: 40px; height: 40px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">
                                <i class="fas fa-th" style="color: #666;"></i>
                            </button>
                            <button class="view-list" onclick="changeView('list')" style="width: 40px; height: 40px; border: 2px solid #e0e0e0; background: #fff; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">
                                <i class="fas fa-list" style="color: #666;"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="row" id="productsGrid">
                    <!-- Product 1 - Premium Casserole -->
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="cookware" data-collection="premium" data-price="89">
                        <div class="product-card" style="background: #fff; border-radius: 20px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.08); height: 100%;">
                            <div class="product-thumb" style="position: relative; padding-top: 100%; background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%); overflow: hidden;">
                                <span style="position: absolute; top: 15px; left: 15px; background: #e74c3c; color: #fff; padding: 6px 18px; border-radius: 20px; font-size: 12px; font-weight: 600; z-index: 2;">SALE</span>
                                <div class="product-actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 10px; z-index: 2;">
                                    <button onclick="addToWishlist(this)" title="Add to Wishlist" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button onclick="addToCompare(this)" title="Compare" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button onclick="quickView(this)" title="Quick View" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=400&h=400&fit=crop" alt="Product" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 85%; max-height: 85%; object-fit: contain;">
                            </div>
                            <div class="product-info" style="padding: 25px; text-align: center;">
                                <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px;">PREMIUM COOKWARE</p>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <a href="product-detail.php" style="color: #1a1a1a; text-decoration: none;">Premium Casserole 28cm</a>
                                </h4>
                                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-family: 'Courier New', monospace;">DH-05468</p>
                                <div class="rating" style="color: #ffa500; font-size: 14px; margin-bottom: 12px;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                    <span style="color: #999; font-size: 13px; margin-left: 5px;">(128)</span>
                                </div>
                                <div class="price" style="margin-bottom: 15px;">
                                    <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$89.00</span>
                                    <del style="font-size: 16px; color: #999; margin-left: 8px;">$110.00</del>
                                </div>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 - Fry Pan -->
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="cookware" data-collection="premium" data-price="75">
                        <div class="product-card" style="background: #fff; border-radius: 20px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.08); height: 100%;">
                            <div class="product-thumb" style="position: relative; padding-top: 100%; background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%); overflow: hidden;">
                                <span style="position: absolute; top: 15px; left: 15px; background: #27ae60; color: #fff; padding: 6px 18px; border-radius: 20px; font-size: 12px; font-weight: 600; z-index: 2;">NEW</span>
                                <div class="product-actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 10px; z-index: 2;">
                                    <button onclick="addToWishlist(this)" title="Add to Wishlist" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button onclick="addToCompare(this)" title="Compare" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button onclick="quickView(this)" title="Quick View" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <img src="https://images.unsplash.com/photo-1556909212-d5b604d0c90d?w=400&h=400&fit=crop" alt="Product" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 85%; max-height: 85%; object-fit: contain;">
                            </div>
                            <div class="product-info" style="padding: 25px; text-align: center;">
                                <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px;">PREMIUM COOKWARE</p>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <a href="product-detail.php" style="color: #1a1a1a; text-decoration: none;">Premium Fry Pan 28cm</a>
                                </h4>
                                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-family: 'Courier New', monospace;">DH-05488</p>
                                <div class="rating" style="color: #ffa500; font-size: 14px; margin-bottom: 12px;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                    <span style="color: #999; font-size: 13px; margin-left: 5px;">(95)</span>
                                </div>
                                <div class="price" style="margin-bottom: 15px;">
                                    <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$75.00</span>
                                </div>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 - GoPress -->
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="cookware" data-collection="gopress" data-price="129">
                        <div class="product-card" style="background: #fff; border-radius: 20px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.08); height: 100%;">
                            <div class="product-thumb" style="position: relative; padding-top: 100%; background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%); overflow: hidden;">
                                <div class="product-actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 10px; z-index: 2;">
                                    <button onclick="addToWishlist(this)" title="Add to Wishlist" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button onclick="addToCompare(this)" title="Compare" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button onclick="quickView(this)" title="Quick View" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <img src="https://images.unsplash.com/photo-1585515320310-259814833e62?w=400&h=400&fit=crop" alt="Product" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 85%; max-height: 85%; object-fit: contain;">
                            </div>
                            <div class="product-info" style="padding: 25px; text-align: center;">
                                <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px;">GOPRESS</p>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <a href="product-detail.php" style="color: #1a1a1a; text-decoration: none;">GoPress Pressure Cooker 6L</a>
                                </h4>
                                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-family: 'Courier New', monospace;">DH-06436</p>
                                <div class="rating" style="color: #ffa500; font-size: 14px; margin-bottom: 12px;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <span style="color: #999; font-size: 13px; margin-left: 5px;">(214)</span>
                                </div>
                                <div class="price" style="margin-bottom: 15px;">
                                    <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$129.00</span>
                                </div>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 - Kettle -->
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="coffee-tea" data-collection="premium" data-price="45">
                        <div class="product-card" style="background: #fff; border-radius: 20px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.08); height: 100%;">
                            <div class="product-thumb" style="position: relative; padding-top: 100%; background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%); overflow: hidden;">
                                <span style="position: absolute; top: 15px; left: 15px; background: #e74c3c; color: #fff; padding: 6px 18px; border-radius: 20px; font-size: 12px; font-weight: 600; z-index: 2;">-25%</span>
                                <div class="product-actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 10px; z-index: 2;">
                                    <button onclick="addToWishlist(this)" title="Add to Wishlist" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button onclick="addToCompare(this)" title="Compare" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button onclick="quickView(this)" title="Quick View" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <img src="https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=400&fit=crop" alt="Product" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 85%; max-height: 85%; object-fit: contain;">
                            </div>
                            <div class="product-info" style="padding: 25px; text-align: center;">
                                <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px;">COFFEE & TEA</p>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <a href="product-detail.php" style="color: #1a1a1a; text-decoration: none;">Whistling Tea Kettle 2.5L</a>
                                </h4>
                                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-family: 'Courier New', monospace;">DH-02906</p>
                                <div class="rating" style="color: #ffa500; font-size: 14px; margin-bottom: 12px;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                    <span style="color: #999; font-size: 13px; margin-left: 5px;">(87)</span>
                                </div>
                                <div class="price" style="margin-bottom: 15px;">
                                    <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$45.00</span>
                                    <del style="font-size: 16px; color: #999; margin-left: 8px;">$60.00</del>
                                </div>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 5 - Cutlery Set -->
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="cutlery" data-collection="premium" data-price="199">
                        <div class="product-card" style="background: #fff; border-radius: 20px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.08); height: 100%;">
                            <div class="product-thumb" style="position: relative; padding-top: 100%; background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%); overflow: hidden;">
                                <div class="product-actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 10px; z-index: 2;">
                                    <button onclick="addToWishlist(this)" title="Add to Wishlist" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button onclick="addToCompare(this)" title="Compare" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button onclick="quickView(this)" title="Quick View" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <img src="https://images.unsplash.com/photo-1578926314433-e2789279f4aa?w=400&h=400&fit=crop" alt="Product" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 85%; max-height: 85%; object-fit: contain;">
                            </div>
                            <div class="product-info" style="padding: 25px; text-align: center;">
                                <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px;">CUTLERY</p>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <a href="product-detail.php" style="color: #1a1a1a; text-decoration: none;">Safari Cutlery Set 72 Pcs</a>
                                </h4>
                                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-family: 'Courier New', monospace;">DH-01998</p>
                                <div class="rating" style="color: #ffa500; font-size: 14px; margin-bottom: 12px;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                    <span style="color: #999; font-size: 13px; margin-left: 5px;">(156)</span>
                                </div>
                                <div class="price" style="margin-bottom: 15px;">
                                    <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$199.00</span>
                                </div>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 6 - Muffin Pan -->
                    <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="bakeware" data-collection="lifetime" data-price="35">
                        <div class="product-card" style="background: #fff; border-radius: 20px; overflow: hidden; transition: all 0.4s ease; box-shadow: 0 5px 25px rgba(0,0,0,0.08); height: 100%;">
                            <div class="product-thumb" style="position: relative; padding-top: 100%; background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%); overflow: hidden;">
                                <div class="product-actions" style="position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 10px; z-index: 2;">
                                    <button onclick="addToWishlist(this)" title="Add to Wishlist" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button onclick="addToCompare(this)" title="Compare" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button onclick="quickView(this)" title="Quick View" style="width: 45px; height: 45px; border-radius: 50%; border: none; background: #fff; color: #1a1a1a; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <img src="https://images.unsplash.com/photo-1495147466023-ac5c588e2e94?w=400&h=400&fit=crop" alt="Product" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 85%; max-height: 85%; object-fit: contain;">
                            </div>
                            <div class="product-info" style="padding: 25px; text-align: center;">
                                <p style="font-size: 12px; color: #4A90E2; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; margin-bottom: 10px;">BAKEWARE</p>
                                <h4 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px; min-height: 45px; display: flex; align-items: center; justify-content: center;">
                                    <a href="product-detail.php" style="color: #1a1a1a; text-decoration: none;">Muffin Pan 12 Cups</a>
                                </h4>
                                <p style="font-size: 13px; color: #999; margin-bottom: 12px; font-family: 'Courier New', monospace;">DH-08908</p>
                                <div class="rating" style="color: #ffa500; font-size: 14px; margin-bottom: 12px;">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                                    <span style="color: #999; font-size: 13px; margin-left: 5px;">(64)</span>
                                </div>
                                <div class="price" style="margin-bottom: 15px;">
                                    <span style="font-size: 24px; font-weight: 700; color: #4A90E2;">$35.00</span>
                                </div>
                                <button onclick="addToCart(this)" style="width: 100%; background: #4A90E2; color: #fff; padding: 12px; border: 2px solid #4A90E2; border-radius: 25px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; font-size: 13px;">
                                    <i class="fas fa-shopping-cart" style="margin-right: 8px;"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper" style="margin-top: 50px; display: flex; justify-content: center;">
                    <ul class="pagination" style="display: flex; gap: 10px; list-style: none; padding: 0; margin: 0;">
                        <li><a href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid #e0e0e0; border-radius: 10px; color: #666; text-decoration: none; transition: all 0.3s ease;"><i class="fas fa-chevron-left"></i></a></li>
                        <li><a href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid #4A90E2; background: #4A90E2; border-radius: 10px; color: #fff; text-decoration: none; font-weight: 600;">1</a></li>
                        <li><a href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid #e0e0e0; border-radius: 10px; color: #666; text-decoration: none; transition: all 0.3s ease; font-weight: 600;">2</a></li>
                        <li><a href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid #e0e0e0; border-radius: 10px; color: #666; text-decoration: none; transition: all 0.3s ease; font-weight: 600;">3</a></li>
                        <li><a href="#" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: 2px solid #e0e0e0; border-radius: 10px; color: #666; text-decoration: none; transition: all 0.3s ease;"><i class="fas fa-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Product Card Hover */
.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.product-card:hover .product-thumb img {
    transform: translate(-50%, -50%) scale(1.1);
}

/* Product Actions Hover */
.product-actions button:hover {
    background: #4A90E2 !important;
    color: #fff !important;
    transform: scale(1.1);
}

/* Add to Cart Button Hover */
.product-info button:hover {
    background: transparent !important;
    color: #4A90E2 !important;
}

/* Filter Hover */
.category-list label:hover,
.collection-list label:hover {
    background: rgba(201, 164, 92, 0.05);
}

/* View Mode Active */
.view-mode button.active {
    border-color: #4A90E2 !important;
    background: #4A90E2 !important;
}

.view-mode button.active i {
    color: #fff !important;
}

.view-mode button:hover {
    border-color: #4A90E2 !important;
}

.view-mode button:hover i {
    color: #4A90E2 !important;
}

/* Reset Button Hover */
button[onclick="resetFilters()"]:hover {
    background: #4A90E2 !important;
    color: #fff !important;
}

/* Pagination Hover */
.pagination a:hover {
    border-color: #4A90E2 !important;
    color: #4A90E2 !important;
}

/* Responsive */
@media (max-width: 991px) {
    .filters-sidebar {
        position: static !important;
    }
}
</style>

<script>
// Price Range Slider
document.getElementById('priceRange').addEventListener('input', function() {
    document.getElementById('priceValue').textContent = '$' + this.value;
    filterProducts();
});

// Search Products
document.getElementById('searchProduct').addEventListener('input', function() {
    filterProducts();
});

// Category Checkboxes
document.querySelectorAll('.category-list input, .collection-list input').forEach(checkbox => {
    checkbox.addEventListener('change', filterProducts);
});

// Filter Products Function
function filterProducts() {
    const searchTerm = document.getElementById('searchProduct').value.toLowerCase();
    const maxPrice = parseInt(document.getElementById('priceRange').value);
    const selectedCategories = Array.from(document.querySelectorAll('.category-list input:checked')).map(cb => cb.value);
    const selectedCollections = Array.from(document.querySelectorAll('.collection-list input:checked')).map(cb => cb.value);

    let visibleCount = 0;

    document.querySelectorAll('.product-item').forEach(product => {
        const productName = product.querySelector('h4').textContent.toLowerCase();
        const productCode = product.querySelector('.product-code').textContent.toLowerCase();
        const productPrice = parseInt(product.dataset.price);
        const productCategory = product.dataset.category;
        const productCollection = product.dataset.collection;

        const matchesSearch = productName.includes(searchTerm) || productCode.includes(searchTerm);
        const matchesPrice = productPrice <= maxPrice;
        const matchesCategory = selectedCategories.length === 0 || 
                               selectedCategories.includes('all') || 
                               selectedCategories.includes(productCategory);
        const matchesCollection = selectedCollections.length === 0 || 
                                 selectedCollections.includes(productCollection);

        if (matchesSearch && matchesPrice && matchesCategory && matchesCollection) {
            product.style.display = 'block';
            visibleCount++;
        } else {
            product.style.display = 'none';
        }
    });

    document.getElementById('productCount').textContent = visibleCount;
}

// Sort Products
document.getElementById('sortBy').addEventListener('change', function() {
    const sortValue = this.value;
    const productsGrid = document.getElementById('productsGrid');
    const products = Array.from(productsGrid.querySelectorAll('.product-item'));

    products.sort((a, b) => {
        if (sortValue === 'price-asc') {
            return parseInt(a.dataset.price) - parseInt(b.dataset.price);
        } else if (sortValue === 'price-desc') {
            return parseInt(b.dataset.price) - parseInt(a.dataset.price);
        } else if (sortValue === 'name-asc') {
            return a.querySelector('h4').textContent.localeCompare(b.querySelector('h4').textContent);
        } else if (sortValue === 'name-desc') {
            return b.querySelector('h4').textContent.localeCompare(a.querySelector('h4').textContent);
        }
        return 0;
    });

    products.forEach(product => productsGrid.appendChild(product));
});

// Change View Mode
function changeView(mode) {
    const grid = document.getElementById('productsGrid');
    const products = grid.querySelectorAll('.product-item');

    if (mode === 'list') {
        products.forEach(product => {
            product.className = 'col-12 mb-4 product-item ' + product.dataset.category;
        });
        document.querySelector('.view-list').classList.add('active');
        document.querySelector('.view-grid').classList.remove('active');
    } else {
        products.forEach(product => {
            product.className = 'col-lg-4 col-md-6 mb-4 product-item ' + product.dataset.category;
        });
        document.querySelector('.view-grid').classList.add('active');
        document.querySelector('.view-list').classList.remove('active');
    }
}

// Reset Filters
function resetFilters() {
    document.getElementById('searchProduct').value = '';
    document.getElementById('priceRange').value = 500;
    document.getElementById('priceValue').textContent = '$500';
    document.querySelectorAll('.category-list input, .collection-list input').forEach(cb => cb.checked = false);
    document.querySelector('.category-list input[value="all"]').checked = true;
    filterProducts();
}

// Add to Cart
function addToCart(button) {
    const productName = button.closest('.product-card').querySelector('h4').textContent;
    button.innerHTML = '<i class="fas fa-check"></i>Added';
    button.style.background = '#27ae60';
    button.style.borderColor = '#27ae60';

    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-shopping-cart"></i>Add to Cart';
        button.style.background = '#4A90E2';
        button.style.borderColor = '#4A90E2';
    }, 2000);

    const cartCount = document.querySelector('.cart-count');
    cartCount.textContent = parseInt(cartCount.textContent) + 1;

    showNotification(productName + ' added to cart!');
}

// Add to Wishlist
function addToWishlist(button) {
    button.querySelector('i').classList.toggle('far');
    button.querySelector('i').classList.toggle('fas');

    if (button.querySelector('i').classList.contains('fas')) {
        button.style.background = '#e74c3c';
        button.style.color = '#fff';
        const wishlistCount = document.querySelector('.wishlist-count');
        wishlistCount.textContent = parseInt(wishlistCount.textContent) + 1;
        showNotification('Added to wishlist!');
    } else {
        button.style.background = '#fff';
        button.style.color = '#1a1a1a';
        const wishlistCount = document.querySelector('.wishlist-count');
        wishlistCount.textContent = parseInt(wishlistCount.textContent) - 1;
    }
}

// Add to Compare
function addToCompare(button) {
    const compareCount = document.querySelector('.compare-count');
    compareCount.textContent = parseInt(compareCount.textContent) + 1;
    button.style.background = '#3498db';
    button.style.color = '#fff';

    setTimeout(() => {
        button.style.background = '#fff';
        button.style.color = '#1a1a1a';
    }, 2000);

    showNotification('Added to compare!');
}

// Quick View
function quickView(button) {
    alert('Quick view modal will open here');
}

// Show Notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.innerHTML = '<i class="fas fa-check-circle" style="margin-right: 10px;"></i>' + message;
    notification.style.cssText = 'position: fixed; top: 100px; right: 30px; background: #27ae60; color: #fff; padding: 18px 30px; border-radius: 50px; font-weight: 600; z-index: 9999; box-shadow: 0 8px 30px rgba(0,0,0,0.2);';

    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>