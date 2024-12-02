<?php
// Database connection
$db_config = [
    'host' => '35.209.175.114',
    'port' => '5432',
    'dbname' => 'dbrsb9vqhcdnqn',
    'user' => 'uq5sl17zwkz9u',
    'password' => '&&m13fi$~%4,'
];

// Pagination settings
$results_per_page = 20;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $results_per_page;

try {
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $pdo = new PDO($dsn, $db_config['user'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Prepare search parameters
$business_name = isset($_GET['business_name']) ? trim($_GET['business_name']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$year = isset($_GET['year']) ? intval($_GET['year']) : '';
$city = isset($_GET['city']) ? trim($_GET['city']) : '';
$state = isset($_GET['state']) ? trim($_GET['state']) : '';

$results = [];
$total_results = 0;
$show_pagination = false;

try {
    // Base query for counting total results
    $count_sql = "SELECT COUNT(*) FROM awards WHERE 1=1";
    $search_sql = "SELECT * FROM awards WHERE 1=1";
    $params = [];

    // Add filters dynamically
    if ($business_name) {
        $count_sql .= " AND business_name ILIKE :business_name";
        $search_sql .= " AND business_name ILIKE :business_name";
        $params[':business_name'] = "%$business_name%";
    }
    if ($category) {
        $count_sql .= " AND category ILIKE :category";
        $search_sql .= " AND category ILIKE :category";
        $params[':category'] = "%$category%";
    }
    if ($year) {
        $count_sql .= " AND year = :year";
        $search_sql .= " AND year = :year";
        $params[':year'] = $year;
    }
    if ($city) {
        $count_sql .= " AND city ILIKE :city";
        $search_sql .= " AND city ILIKE :city";
        $params[':city'] = "%$city%";
    }
    if ($state) {
        $count_sql .= " AND state ILIKE :state";
        $search_sql .= " AND state ILIKE :state";
        $params[':state'] = "%$state%";
    }

    // Execute count query for total pagination calculation
    $count_stmt = $pdo->prepare($count_sql);
    foreach ($params as $key => $value) {
        $count_stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $count_stmt->execute();
    $total_results = $count_stmt->fetchColumn();

    // Set pagination values
    $total_pages = ceil($total_results / $results_per_page);
    $show_pagination = $total_pages > 1;

    // Execute search query with limit and offset for pagination
    $search_sql .= " ORDER BY year DESC, business_name LIMIT :limit OFFSET :offset";
    $params[':limit'] = $results_per_page;
    $params[':offset'] = $offset;

    $search_stmt = $pdo->prepare($search_sql);
    foreach ($params as $key => $value) {
        $search_stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    $search_stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
    $search_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $search_stmt->execute();
    $results = $search_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Search Error: " . $e->getMessage());
    $error = "An error occurred while searching.";
}

// Function to generate pagination URL
function get_pagination_url($page) {
    $params = $_GET;
    $params['page'] = $page;
    return '?' . http_build_query($params);
}

// Function to get archive URL path
function get_archive_url($innerpage) {
    $path = parse_url($innerpage, PHP_URL_PATH);
    if (!$path) {
        $path = preg_replace('#^https?://[^/]+#', '', $innerpage);
    }
    return "https://archive.qualitybusinessawards.com" . $path;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Business Awards Archive - Past Winners</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .autocomplete-suggestions {
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            position: absolute;
            z-index: 1000;
            width: 100%;
            border-radius: 0.5rem;
        }
        .autocomplete-suggestion {
            padding: 0.5rem;
            cursor: pointer;
        }
        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-white to-blue-50">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="flex justify-center mb-8">
            <img 
                src="https://qualitybusinessawards.ca/wp-content/uploads/2022/11/logo-tran.png"
                alt="Quality Business Awards Logo"
                class="h-24 w-auto"
            >
        </div>

        <!-- Search Form -->
        <div class="max-w-2xl mx-auto mb-20 relative">
            <form action="canada.php" method="GET" class="space-y-4">
                <div class="relative">
                    <input type="text" name="business_name" id="business_name" placeholder="Business Name" value="<?php echo htmlspecialchars($business_name); ?>" class="w-full px-4 py-3 border rounded-md">
                    <div id="business_name_suggestions" class="autocomplete-suggestions"></div>
                </div>
                <input type="text" name="category" placeholder="Category" value="<?php echo htmlspecialchars($category); ?>" class="w-full px-4 py-3 border rounded-md">
                <input type="number" name="year" placeholder="Year" value="<?php echo htmlspecialchars($year); ?>" class="w-full px-4 py-3 border rounded-md">
                <input type="text" name="city" placeholder="City" value="<?php echo htmlspecialchars($city); ?>" class="w-full px-4 py-3 border rounded-md">
                <input type="text" name="state" placeholder="State" value="<?php echo htmlspecialchars($state); ?>" class="w-full px-4 py-3 border rounded-md">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-md font-semibold">
                    Search
                </button>
            </form>
        </div>

        <!-- Search Results Section -->
        <?php if (!empty($results)): ?>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-semibold mb-4">
                <?php echo number_format($total_results); ?> Results Found
            </h2>
            <div class="space-y-6">
                <?php foreach ($results as $result): ?>
                <div class="border-b pb-4">
                    <a href="<?php echo htmlspecialchars(get_archive_url($result['innerpage'])); ?>" class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                        <?php echo htmlspecialchars($result['business_name']); ?>
                    </a>
                    <p><?php echo htmlspecialchars($result['category']); ?> • <?php echo htmlspecialchars($result['city']); ?>, <?php echo htmlspecialchars($result['state']); ?> • <?php echo htmlspecialchars($result['year']); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <p class="text-gray-600">No results found. Try adjusting your search criteria.</p>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($show_pagination): ?>
        <div class="flex items-center justify-center space-x-2 mt-6">
            <?php if ($current_page > 1): ?>
            <a href="<?php echo get_pagination_url($current_page - 1); ?>" class="px-4 py-2 border rounded-md">Previous</a>
            <?php endif; ?>

            <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                <a href="<?php echo get_pagination_url($page); ?>" class="px-4 py-2 border rounded-md <?php if ($page == $current_page) echo 'bg-blue-600 text-white'; ?>">
                    <?php echo $page; ?>
                </a>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
            <a href="<?php echo get_pagination_url($current_page + 1); ?>" class="px-4 py-2 border rounded-md">Next</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#business_name').on('input', function() {
                let term = $(this).val();
                if (term.length > 1) { // Start fetching after 2 characters
                    $.ajax({
                        url: 'autocomplete.php',
                        method: 'GET',
                        data: { term: term },
                        success: function(data) {
                            console.log("Autocomplete data:", data); // Debugging line
                            let suggestions = JSON.parse(data);
                            let suggestionBox = $('#business_name_suggestions');
                            suggestionBox.empty();
                            suggestions.forEach(function(item) {
                                suggestionBox.append('<div class="autocomplete-suggestion">' + item + '</div>');
                            });
                        }
                    });
                } else {
                    $('#business_name_suggestions').empty();
                }
            });

            // Handle click on suggestions
            $(document).on('click', '.autocomplete-suggestion', function() {
                $('#business_name').val($(this).text());
                $('#business_name_suggestions').empty();
            });

            // Close suggestions when clicking outside
            $(document).click(function(event) {
                if (!$(event.target).closest('#business_name').length) {
                    $('#business_name_suggestions').empty();
                }
            });
        });
    </script>
</body>
</html>
