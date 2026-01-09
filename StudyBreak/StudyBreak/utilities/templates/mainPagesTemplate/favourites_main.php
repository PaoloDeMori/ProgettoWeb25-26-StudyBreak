<section id="favourites">
            <h2>
                Your Favourites
            </h2>
            <ul>
            </ul>
        </section>

        <section>
            <h2>
                Customizations
            </h2>
            <ul>
                <?php foreach($favouritesParams["customs"] as $custom): ?>
                    <?php include("../../utilities/templates/custom-card.php"); ?>
                <?php endforeach; ?>
            </ul>
        </section>