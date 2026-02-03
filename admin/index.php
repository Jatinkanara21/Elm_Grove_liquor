<?php
$metrics = [
    [
        'title' => 'Today\'s Orders',
        'value' => '42',
        'description' => 'Online, phone, and walk-in reservations.'
    ],
    [
        'title' => 'Featured Inventory',
        'value' => '128',
        'description' => 'Curated bottles ready for promotion.'
    ],
    [
        'title' => 'Tasting RSVPs',
        'value' => '76',
        'description' => 'Guests registered for the weekend event.'
    ]
];

$inventory = [
    [
        'item' => 'Oak & Ember Bourbon',
        'category' => 'Spirits',
        'status' => 'Low stock',
        'next_delivery' => 'Oct 18'
    ],
    [
        'item' => 'Lakefront Gin',
        'category' => 'Spirits',
        'status' => 'On order',
        'next_delivery' => 'Oct 20'
    ],
    [
        'item' => 'Reserve Cabernet',
        'category' => 'Wine',
        'status' => 'In stock',
        'next_delivery' => 'Oct 15'
    ],
    [
        'item' => 'Craft IPA Pack',
        'category' => 'Beer',
        'status' => 'In stock',
        'next_delivery' => 'Oct 16'
    ]
];
?>
<?php include __DIR__ . '/includes/admin_header.php'; ?>
<main class="admin-main">
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome back! Here is your snapshot of Elm Grove Liquor operations.</p>

        <div class="admin-grid">
            <?php foreach ($metrics as $metric): ?>
                <div class="admin-card">
                    <h3><?php echo $metric['title']; ?></h3>
                    <p class="tag"><?php echo $metric['value']; ?></p>
                    <p><?php echo $metric['description']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="notice">
            Inventory refresh scheduled for tomorrow at 8:00 AM. Please review any urgent purchase orders.
        </div>

        <h2 style="margin-top: 2rem;">Inventory overview</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Next Delivery</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory as $item): ?>
                    <tr>
                        <td><?php echo $item['item']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo $item['status']; ?></td>
                        <td><?php echo $item['next_delivery']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include __DIR__ . '/includes/admin_footer.php'; ?>
