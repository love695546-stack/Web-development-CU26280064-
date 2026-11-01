
// 1. Mobile Hamburger Menu
let menuBtn = document.getElementById("menuBtn");
let navLinks = document.getElementById("navLinks");

menuBtn.addEventListener("click", function() {
    navLinks.classList.toggle("active");
});

// Mobile menu link click par close
let links = document.querySelectorAll(".nav-links a");

links.forEach(function(link) {
    link.addEventListener("click", function() {
        navLinks.classList.remove("active");
    });
});


// 2. Dark and Light Mode
let themeBtn = document.getElementById("themeBtn");

themeBtn.addEventListener("click", function() {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        themeBtn.innerText = "Light Mode";
    } else {
        themeBtn.innerText = "Dark Mode";
    }
});


// 3. Contact Form Validation
let contactForm = document.getElementById("contactForm");

contactForm.addEventListener("submit", function(event) {
    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let message = document.getElementById("message").value.trim();

    let formMessage = document.getElementById("formMessage");

    if (name === "" || email === "" || message === "") {
        formMessage.innerText = "Please fill all fields!";
        formMessage.style.color = "red";
    } else {
        formMessage.innerText = "Form submitted successfully!";
        formMessage.style.color = "green";

        contactForm.reset();
    }
});


// 4. FAQ Accordion
let questions = document.querySelectorAll(".faq-question");

questions.forEach(function(question) {
    question.addEventListener("click", function() {

        let answer = question.nextElementSibling;

        if (answer.style.display === "block") {
            answer.style.display = "none";
        } else {
            answer.style.display = "block";
        }

    });
});


// 5. Testimonials Slider
let testimonials = [
    {
        name: "Rahul",
        text: "Great work and excellent design!"
    },
    {
        name: "Amit",
        text: "Very professional and creative developer."
    },
    {
        name: "Priya",
        text: "I really like this website."
    }
];

let currentIndex = 0;

let testimonialText = document.getElementById("testimonialText");
let testimonialName = document.getElementById("testimonialName");

function showTestimonial() {
    testimonialText.style.opacity = "0";

    setTimeout(function() {
        testimonialText.innerText = testimonials[currentIndex].text;
        testimonialName.innerText = "- " + testimonials[currentIndex].name;
        testimonialText.style.opacity = "1";
    }, 200);
}

document.getElementById("nextBtn").addEventListener("click", function() {
    currentIndex++;

    if (currentIndex >= testimonials.length) {
        currentIndex = 0;
    }

    showTestimonial();
});

document.getElementById("prevBtn").addEventListener("click", function() {
    currentIndex--;

    if (currentIndex < 0) {
        currentIndex = testimonials.length - 1;
    }

    showTestimonial();
});


// 6. Back to Top Button
let topBtn = document.getElementById("topBtn");

window.addEventListener("scroll", function() {
    if (window.scrollY > 200) {
        topBtn.style.display = "block";
    } else {
        topBtn.style.display = "none";
    }
});

topBtn.addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});


// 7. Modal Popup
let modal = document.getElementById("modal");
let openModal = document.getElementById("openModal");
let closeModal = document.getElementById("closeModal");

openModal.addEventListener("click", function() {
    modal.style.display = "flex";
});

closeModal.addEventListener("click", function() {
    modal.style.display = "none";
});

modal.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
});


// 8. Project Search Filter
let searchInput = document.getElementById("searchInput");
let projectCards = document.querySelectorAll(".project-card");

searchInput.addEventListener("input", function() {
    let searchValue = searchInput.value.toLowerCase();

    projectCards.forEach(function(card) {
        let projectName = card.innerText.toLowerCase();

        if (projectName.includes(searchValue)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
});


// 9. Statistics Counter Animation
let counters = document.querySelectorAll(".counter");
let counterStarted = false;

window.addEventListener("scroll", function() {

    let stats = document.querySelector(".stats");
    let statsPosition = stats.getBoundingClientRect().top;

    if (statsPosition < window.innerHeight && counterStarted === false) {

        counterStarted = true;

        counters.forEach(function(counter) {

            let target = Number(counter.getAttribute("data-target"));
            let count = 0;

            let interval = setInterval(function() {

                count++;

                counter.innerText = count;

                if (count >= target) {
                    clearInterval(interval);
                }

            }, 100);

        });

    }

});
