const queryInput = document.querySelector(".event-lieu-input");

const awesomplete = new Awesomplete(queryInput, {
  filter: () => { // We will provide a list that is already filtered ...
    return true;
  },
  sort: false,    // ... and sorted.
  list: []
});

queryInput.addEventListener("input", (event) => {
    const query = queryInput.value;
    if (!query || query === "") return;
    $.ajax({
        url: "https://api.geoapify.com/v1/geocode/autocomplete?text="
            + query + "&type=locality&format=json&apiKey=0a4d3f8022eb4a00a7e0a30ee86ef8d2"
    }).then(function(data) {
        awesomplete.list = data.results.map(l => {
            return l.formatted;
        });
        awesomplete.evaluate();
    });
});