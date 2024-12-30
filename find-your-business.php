<?php require('includes/header.php'); ?>
<style>
    .autocomplete-suggestions {
        border: 1px solid #ddd;
        background: white;
        overflow: auto;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 9999;
        max-height: 300px;
        width: 100%;
        border-radius: 0.5rem;
        margin-top: -1px;
    }
    .suggestion-group-header {
        padding: 12px 15px;
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 0.9em;
        color: #495057;
        border-bottom: 1px solid #dee2e6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 1;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .autocomplete-suggestion {
        padding: 12px 15px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center; /* Changed from flex-start to center */
        border-bottom: 1px solid #eee;
        gap: 10px;
    }
    .suggestion-content {
        flex: 1;
        min-width: 0;
    }
    .business-name {
        font-weight: 600;
        margin-bottom: 4px;
        color: #333;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .business-details {
        font-size: 0.85em;
        color: #666;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .business-category, .business-location {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .suggestion-select-btn {
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
        min-width: 80px;
        text-align: center;
    }
    .suggestion-select-btn:hover {
        background-color: #0056b3;
    }
    .manual-search-option {
        background-color: #fff3e6;
        padding: 15px;
        border-bottom: none;
        position: sticky;
        bottom: 0;
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }
    .manual-search-option .suggestion-select-btn {
        background-color: #ff9933;
    }
    .manual-search-option .suggestion-select-btn:hover {
        background-color: #ff8000;
    }

    /* Mobile Responsiveness */
    @media (max-width: 576px) {
        .suggestion-group-header {
            padding: 10px;
            font-size: 0.85em;
        }
        .autocomplete-suggestion {
            padding: 10px;
            /* Removed flex-direction: column */
        }
        .suggestion-content {
            flex: 1;
            /* Added to ensure content doesn't push button too far */
            overflow: hidden;
        }
        .business-details {
            margin-top: 4px;
        }
        .suggestion-select-btn {
            padding: 6px 12px;
            font-size: 0.9em;
            /* Removed width: 100% to keep it on the right */
        }
        .manual-search-option {
            flex-direction: row; /* Keep the row direction */
            padding: 12px;
        }
        .manual-search-option .suggestion-content {
            font-size: 0.9em;
        }
    }
</style>
<!-- Rest of your existing code remains the same -->

<div class="home_hero gym_lock" style="background-image: url(images/single-header.png);">
    <div class="container">
        <p>Find The Winners of The <span>2025 Quality Business Awards</span></p>
        <h2>QUALITY BUSINESS AWARDS</h2>
        <a href="search" class="btn">SEARCH WINNERS</a>
    </div>
</div>

<?php 
$type = isset($_GET['type']) ? trim($_GET['type']) : ''; 
?>

<section class="business_finder" id="form">
    <div class="container col-md-9">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="businessQuality_finder mt-0">
                    <div class="common_title">
                        <h2><span>Let's Find</span> Your Business</h2>
                    </div>

                    <ul class="list-unstyled steps_count">
                        <li class="active"><span>1</span> <small>Step1</small></li>
                        <li><span>2</span> <small>Step2</small></li>
                        <li><span>3</span> <small>Step3</small></li>
                    </ul>

                    <form action="/find-your-business-result" class="searh_form flex-column" method="GET">
                        <div class="search-container">
                            <input type="text" 
                                   class="form-control" 
                                   id="business_name" 
                                   name="business_name" 
                                   placeholder="Search by business name" 
                                   autocomplete="off" 
                                   style="width:100%;">
                            <div id="business_suggestions" class="autocomplete-suggestions"></div>
                        </div>
                        <input type="hidden" id="type" name="type" value="<?php echo htmlspecialchars($type); ?>" >
                        <input type="submit" class="btn" value="Find Business">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require('includes/footer.php'); ?>

<script>
$(document).ready(function() {

    const businessInput = $('#business_name');
    const suggestionsBox = $('#business_suggestions');
    
    function getIconForType(type) {
        switch(type) {
            case 'business':
                return '<i class="fas fa-building"></i>';
            case 'category':
                return '<i class="fas fa-tag"></i>';
            case 'location':
                return '<i class="fas fa-map-marker-alt"></i>';
            default:
                return '';
        }
    }

    businessInput.on('input', function() {
        const term = $(this).val();
        
        if (term.length > 1) {
            suggestionsBox.html('<div class="p-3 text-center">Loading...</div>');
            
            $.ajax({
                url: 'autocomplete-all.php',
                method: 'GET',
                data: { 
                    term: term,
                    type: 'all'
                },
                success: function(data) {
                    let results = JSON.parse(data);
                    suggestionsBox.empty();
                    
                    // Add businesses
                    if (results.businesses.length > 0) {
                        suggestionsBox.append('<div class="suggestion-group-header">Businesses</div>');
                        results.businesses.forEach(function(item) {
                            const suggestionDiv = $(`
                                <div class="autocomplete-suggestion" data-type="business">
                                    <div class="suggestion-content">
                                        <div class="business-name">
                                            ${getIconForType('business')} ${item.text}
                                        </div>
                                        <div class="business-details">
                                            <span class="business-category">
                                                ${getIconForType('category')} ${item.category}
                                            </span>
                                            <span class="business-location">
                                                ${getIconForType('location')} ${item.city}, ${item.state}
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" class="suggestion-select-btn">Select</button>
                                </div>
                            `);
                            suggestionDiv.data('business', item);
                            suggestionsBox.append(suggestionDiv);
                        });
                    }

                    // Add manual search option
                    suggestionsBox.append(`
                        <div class="autocomplete-suggestion manual-search-option">
                            <div class="suggestion-content">
                                <span>Can't Find Your Business? Click to have us manually locate it for you</span>
                            </div>
                            <button type="button" class="suggestion-select-btn">Select</button>
                        </div>
                    `);
                },
                error: function() {
                    suggestionsBox.html('<div class="p-3 text-center text-danger">Error loading suggestions</div>');
                }
            });
        } else {
            suggestionsBox.empty();
        }
    });

    // Handle selection via button click
    $(document).on('click', '.suggestion-select-btn', function() {
        const suggestionText = $(this).prev('span').text();
        const isManualSearch = $(this).closest('.autocomplete-suggestion').hasClass('manual-search-option');
        const type = $(this).closest('.autocomplete-suggestion').data('type');
        const currentType = $('#type').val();
        
        if (isManualSearch) {
            const url = `/payment-step?business_ID=0&type=${encodeURIComponent(currentType)}#form`;
            window.location.href = url;
        }else if (type === 'business') {
            const businessData = $(this).closest('.autocomplete-suggestion').data('business');
            const url = `/payment-step?business_name=${encodeURIComponent(businessData.text)}&id=${encodeURIComponent(businessData.id)}&category=${encodeURIComponent(businessData.category)}&state=${encodeURIComponent(businessData.state)}&type=${encodeURIComponent(currentType)}#form`;
            window.location.href = url;
        } 
        suggestionsBox.empty();
    });

    // Close suggestions when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest('.search-container').length) {
            suggestionsBox.empty();
        }
    });
    
});
</script>