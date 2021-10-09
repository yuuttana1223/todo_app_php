"use strict";
{
  const checkboxes = document.querySelectorAll("input[type='checkbox']");
  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", () => {
      const {
        dataset: { id, token },
      } = checkbox;
      fetch("?action=toggle", {
        method: "POST",
        body: new URLSearchParams({
          id: id,
          token: token,
        }),
      });

      checkbox.nextElementSibling.classList.toggle("done");
    });
  });

  const deletes = document.querySelectorAll(".delete");
  deletes.forEach((span) => {
    span.addEventListener("click", () => {
      if (!confirm("Are you sure?")) {
        return;
      }
      console.log(span.parentNode);
      span.parentNode.submit();
    });
  });

  const purge = document.querySelector(".purge");
  purge.addEventListener("click", () => {
    if (!confirm("Are you sure?")) {
      return;
    }
    purge.parentNode.submit();
  });
}
