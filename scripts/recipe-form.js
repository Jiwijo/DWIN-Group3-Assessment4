(function () {
  "use strict";

  const MAX_PHOTO = 4 * 1024 * 1024;
  const MIN_PHOTO = 2 * 1024 * 1024;
  const PHOTO_DEFAULT_MSG = "Images cannot exceed 4MB.";

  const $ = (id) => document.getElementById(id);
  const form = $("recipe-form");
  const typeSingle = $("type-single");
  const typeMulti = $("type-multi");
  const partsEl = $("parts");
  const addPartBtn = $("add-part");
  const description = $("description");
  const remaining = $("remaining");
  const status = $("status");

  const photoInput = $("photo");
  const photoName = $("photo-name");
  const uploadBtn = $("upload-btn");
  const photoMsg = $("photo-msg");
  const photoPreview = $("photo-preview");
  let photoReady = false;
  let photoUrl = "";
  let uid = 0;

  if (description) {
    remaining.textContent = 300 - description.value.length;
    description.addEventListener("input", () => {
      remaining.textContent = 300 - description.value.length;
    });
  }

  function ingredientRow(partId) {
    const row = document.createElement("div");
    row.className = "recipe-row";
    row.innerHTML =
      '<input type="text" class="form-control" name="parts[' + partId + '][ingredients][]" aria-label="Ingredient" placeholder="eg. 2 cups plain flour">' +
      '<button type="button" class="recipe-remove" aria-label="Remove ingredient">&times;</button>';
    row.querySelector("button").addEventListener("click", () => row.remove());
    return row;
  }

  function renumberSteps(list) {
    list.querySelectorAll(".step-label").forEach((l, i) => (l.textContent = "Step " + (i + 1)));
  }

  function stepRow(partId) {
    const id = "step-" + ++uid;
    const wrap = document.createElement("div");
    wrap.className = "recipe-step";
    wrap.innerHTML =
      '<div class="recipe-step-head">' +
        '<label class="step-label" for="' + id + '"></label>' +
        '<button type="button" class="recipe-remove" aria-label="Remove step">&times;</button>' +
      '</div>' +
      '<textarea id="' + id + '" class="form-control" rows="3" name="parts[' + partId + '][method][]" placeholder="Describe this step"></textarea>';
    wrap.querySelector("button").addEventListener("click", () => {
      const list = wrap.parentElement;
      wrap.remove();
      renumberSteps(list);
    });
    return wrap;
  }

  function addPart() {
    const partId = ++uid;
    const part = document.createElement("div");
    part.className = "recipe-part";
    part.innerHTML =
      '<input type="text" class="form-control part-name" name="parts[' + partId + '][name]" placeholder="Part name, eg. Cake" aria-label="Part name" hidden>' +
      '<div class="recipe-part-cols">' +
        '<div>' +
          '<h3>Ingredients *</h3><div class="ingredients"></div>' +
          '<p class="recipe-hint">Enter one ingredient at a time</p>' +
          '<button type="button" class="btn btn-outline-recipe btn-sm add-ing">+ Add Ingredient</button>' +
        '</div>' +
        '<div>' +
          '<h3>Method *</h3><div class="method"></div>' +
          '<p class="recipe-hint">Enter one step at a time</p>' +
          '<button type="button" class="btn btn-outline-recipe btn-sm add-step">+ Add Step</button>' +
        '</div>' +
      '</div>' +
      '<div class="recipe-part-actions"><button type="button" class="btn btn-outline-recipe btn-sm remove-part" hidden>Remove this part</button></div>';

    const ing = part.querySelector(".ingredients");
    const met = part.querySelector(".method");
    ing.append(ingredientRow(partId), ingredientRow(partId));
    met.append(stepRow(partId));
    renumberSteps(met);

    part.querySelector(".add-ing").addEventListener("click", () => {
      const r = ingredientRow(partId);
      ing.append(r);
      r.querySelector("input").focus();
    });
    part.querySelector(".add-step").addEventListener("click", () => {
      const r = stepRow(partId);
      met.append(r);
      renumberSteps(met);
      r.querySelector("textarea").focus();
    });
    part.querySelector(".remove-part").addEventListener("click", () => {
      part.remove();
      syncType();
    });

    partsEl.append(part);
    syncType();
  }

  function syncType() {
    const multi = typeMulti.checked;
    const count = partsEl.children.length;
    addPartBtn.hidden = !multi;
    partsEl.querySelectorAll(".part-name").forEach((el) => (el.hidden = !multi));
    partsEl.querySelectorAll(".remove-part").forEach((el) => (el.hidden = !(multi && count > 1)));
  }

  [typeSingle, typeMulti].forEach((radio) =>
    radio.addEventListener("change", () => {
      if (typeSingle.checked && partsEl.children.length > 1) {
        if (!confirm("Switching to a single part recipe removes the extra parts. Continue?")) {
          typeMulti.checked = true;
          return;
        }
        Array.from(partsEl.children).slice(1).forEach((p) => p.remove());
      }
      syncType();
    })
  );
  addPartBtn.addEventListener("click", addPart);

  function setPhotoMsg(text, isError) {
    photoMsg.textContent = text;
    photoMsg.classList.toggle("recipe-error", isError);
    photoMsg.classList.toggle("recipe-hint", !isError);
  }

  function photoProblem(file) {
    const validType = file.type === "image/jpeg" || file.type === "image/png";
    const validName = /\.(jpe?g|png)$/i.test(file.name);
    if (!validType || !validName) return "Images must be JPG, JPEG or PNG format.";
    if (file.size > MAX_PHOTO) return "Images cannot exceed 4MB.";
    return "";
  }

  function clearPhoto() {
    if (photoUrl) URL.revokeObjectURL(photoUrl);
    photoUrl = "";
    photoReady = false;
    photoPreview.hidden = true;
    photoPreview.removeAttribute("src");
  }

  photoInput.addEventListener("change", () => {
    clearPhoto();
    const file = photoInput.files[0];
    if (!file) {
      photoName.textContent = "No file chosen";
      uploadBtn.disabled = true;
      setPhotoMsg(PHOTO_DEFAULT_MSG, false);
      return;
    }
    photoName.textContent = file.name;
    const problem = photoProblem(file);
    uploadBtn.disabled = Boolean(problem);
    setPhotoMsg(problem || PHOTO_DEFAULT_MSG, Boolean(problem));
  });

  uploadBtn.addEventListener("click", () => {
    const file = photoInput.files[0];
    if (!file) return;
    const problem = photoProblem(file);
    if (problem) return setPhotoMsg(problem, true);
    clearPhoto();
    photoUrl = URL.createObjectURL(file);
    photoPreview.src = photoUrl;
    photoPreview.hidden = false;
    photoReady = true;
    setPhotoMsg(
      file.size < MIN_PHOTO
        ? "Photo added. Images under 2MB may look low quality in your printed cookbook."
        : "Photo added.",
      false
    );
  });

  $("cancel-btn").addEventListener("click", () => {
    if (confirm("Cancel this recipe? Anything you've entered will be cleared.")) {
      window.location.href = "create-recipe.php";
    }
  });

  form.addEventListener("submit", (e) => {
    const title = form.elements["title"].value.trim();
    const category = form.elements["category"].value;

    let partsBad = false;
    Array.from(partsEl.children).forEach((p) => {
      const ingCount = Array.from(p.querySelectorAll('[name*="[ingredients][]"]')).some((i) => i.value.trim());
      const stepCount = Array.from(p.querySelectorAll('[name*="[method][]"]')).some((i) => i.value.trim());
      if (!ingCount || !stepCount) partsBad = true;
    });

    if (!title || !category || partsBad || !photoReady) {
      e.preventDefault();
      status.textContent = "Please fill in the required fields, including uploading a photo.";
      status.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  });

  addPart();
})();