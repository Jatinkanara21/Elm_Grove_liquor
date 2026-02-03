<?php
$featuredSelections = [
    [
        'name' => 'Small-Batch Bourbon',
        'description' => 'Aged in charred oak barrels for a warm, caramel finish.'
    ],
    [
        'name' => 'Lakefront Gin',
        'description' => 'Crisp botanicals with bright citrus and juniper notes.'
    ],
    [
        'name' => 'Reserve Cabernet',
        'description' => 'Rich berry flavors balanced with smooth oak.'
    ],
    [
        'name' => 'Craft IPA Pack',
        'description' => 'Six rotating Wisconsin brews curated weekly.'
    ]
];

$services = [
    'Personalized beverage recommendations from certified staff.',
    'Corporate and event ordering with same-day fulfillment.',
    'Weekly tasting events featuring local distilleries and wineries.'
];
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <p>Neighborhood spirit specialists since 1985.</p>
                <h1>Your curated destination for premium spirits, wine, and craft beer.</h1>
                <p>Elm Grove Liquor brings together boutique brands, local favorites, and concierge-level service to elevate every celebration.</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="#selections">Explore selections</a>
                    <a class="btn btn-outline" href="#services">Plan an event</a>
                </div>
            </div>
            <div>
                <div class="card">
                    <h3>Today's featured flight</h3>
                    <p>Oak & Ember bourbon tasting | Friday 4-7 PM</p>
                    <p class="tag">Free tasting</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="selections">
        <div class="container">
            <h2 class="section-title">Featured selections</h2>
            <div class="cards">
                <?php foreach ($featuredSelections as $selection): ?>
                    <div class="card">
                        <h3><?php echo $selection['name']; ?></h3>
                        <p><?php echo $selection['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section" id="services">
        <div class="container highlight">
            <div>
                <h2 class="section-title">Concierge services</h2>
                <p>We curate pairings, build custom cases, and organize delivery so you can focus on your guests.</p>
                <ul>
                    <?php foreach ($services as $service): ?>
                        <li><?php echo $service; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card">
                <h3>Event request</h3>
                <p>Tell us about your upcoming celebration and our team will provide a custom quote within 24 hours.</p>
                <p class="tag">events@elmgroveliquor.com</p>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
