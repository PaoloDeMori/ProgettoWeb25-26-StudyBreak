<header>
            <button type="button" aria-current="page" id="open-searchbar">
                <img src="../../img/icons/search.svg" alt="search icon" />
            </button>
            <form action="#" method="GET" id="search">
                <label for="search-bar"> Search Bar</label>
                <input id="search-bar" type="text" placeholder="Search..." />
                <button type="reset" id="exit">
                    <img src="../../img/icons/exit_search.svg" alt="exit" />
                </button>
            </form>
            <a href="filters.php" id="filter-btn">
                <img src="../../img/icons/filters.svg" alt="filters' icon" />
            </a>
        </header>

        <section id="all-products">
            <h2>
                Your Products
            </h2>
            <ul>

            </ul>
        </section>

        <section id="search-results">
            <h2>
                Searched Product
            </h2>
            <ul id="results-list"></ul>
        </section>