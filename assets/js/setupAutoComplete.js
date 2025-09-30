function setupAutocomplete(input, items, fuzzySearchFn) {
  let suggestionList = items;

  function updateSuggstionList(newItems) {
    suggestionList = newItems;
  }

  function showSuggestions() {
    const parent = input.parentNode;
    const slc = parent.querySelector(".suggestionList");

    const val = input.value.toLowerCase();
    slc.innerHTML = "";
    slc.style.border = "1px solid #ddd";

    if (!val) {
      slc.style.border = "none";
      return;
    }

    suggestionList
      .filter((item) => fuzzySearchFn(item, val))
      .forEach((item) => {
        const div = document.createElement("div");
        div.textContent = item;
        div.onclick = () => {
          input.value = item;
          slc.style.border = "none";
          slc.innerHTML = "";
        };
        slc.appendChild(div);
      });
  }

  input.addEventListener("input", showSuggestions);
  input.addEventListener("focus", showSuggestions);

  // Optionally hide suggestions on blur (clicking outside)
  input.addEventListener("blur", () => {
    const parent = input.parentNode;
    const slc = parent.querySelector(".suggestionList");
    setTimeout(() => {
      slc.style.border = "none";
      slc.innerHTML = "";
    }, 200); // delay to allow click event on suggestion div
  });

  return { updateSuggstionList };
}
