const filter = document.querySelector("#search");
const filterChoices = document.querySelectorAll(".filter-choices p");

filterChoices.forEach((choice) => {
  choice.addEventListener("click", function (e) {
    filterChoices.forEach((choice) => {
      choice.classList.remove("active");
    });
    choice.classList.add("active");
    const jobs = document.querySelectorAll(".job");
    for (let i = 0; i < jobs.length; i++) {
      if (
        e.currentTarget.innerText ===
        jobs[i].querySelector(".job-type").innerText
      ) {
        jobs[i].style.display = "block";
      } else {
        jobs[i].style.display = "none";
      }
    }
  });
});
filter.addEventListener("input", function () {
  const search = filter.value.toLowerCase();
  const jobs = document.querySelectorAll(".job");
  for (let i = 0; i < jobs.length; i++) {
    const job = jobs[i];
    const title = job.querySelector(".job-title");
    const company = job.querySelector(".company-title");
    if (
      title.innerText.toLowerCase().includes(search) ||
      company.innerText.toLowerCase().includes(search)
    ) {
      job.style.display = "block";
    } else {
      job.style.display = "none";
    }
  }
});

const jobSection = document.querySelector(".jobs-section");

jobSection.addEventListener("", (e) => {
  console.log(e);
});
