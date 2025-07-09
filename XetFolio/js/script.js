
// // Typing animation
// var typed = new Typed(".typing", {
//   strings: [
//     "",
//     "Web",
//     "Web Designer",
//     "Web Developer",
//     "Content Creator",
//   ],
//   typeSpeed: 100,
//   BackSpeed: 60,
//   loop: true,
// });

// // Aside
// const nav = document.querySelector(".nav"),
//   navList = nav.querySelectorAll("li"),
//   totalNavList = navList.length,
//   allSection = document.querySelectorAll(".section"),
//   totalSection = allSection.length;

// for (let i = 0; i < totalNavList; i++) {
//   const a = navList[i].querySelector("a");
//   a.addEventListener("click", function () {
//     for (let k = 0; k < totalSection; k++) {
//       allSection[k].classList.remove("back-section");
//     }
//     //Loop for removing active class
//     for (let j = 0; j < totalNavList; j++) {
//       if (navList[j].querySelector("a").classList.contains("active")) {
//         allSection[j].classList.add("back-section");
//       }
//       navList[j].querySelector("a").classList.remove("active");
//     }
//     //Adding active class
//     this.classList.add("active");
//     showSection(this); //Function call
//     //Nav click event - Hiding the nav menu
//     if (window.innerWidth < 1200) {
//       asideSectionTogglerBtn();
//     }
//   });
// }
  
// function showSection(element) {
//   //Loop for removing active class
//   for (let k = 0; k < totalSection; k++) {
//     allSection[k].classList.remove("active");
//   }
//   const target = element.getAttribute("href").split("#")[1];
//   document.querySelector("#" + target).classList.add("active");
// } 

// //For Hire me section
// document.querySelector(".hire-me").addEventListener("click", function () {
//   showSection(this);
//   updateNav(this);
// });

// function updateNav(element) {
//   for (let i = 0; i < totalNavList; i++) {
//     navList[i].querySelector("a").classList.remove("active");
//     const target = element.getAttribute("href").split("#")[1];
//     if (
//       target ===
//       navList[i].querySelector("a").getAttribute("href").split("#")[1]
//     ) {
//       navList[i].querySelector("a").classList.add("active");
//     }
//   }
// }

// //For Nav Toggler Button
// const navTogglerBtn = document.querySelector(".nav-toggler"),
//   aside = document.querySelector(".aside");
// navTogglerBtn.addEventListener("click", () => {
//   asideSectionTogglerBtn();
// });

// function asideSectionTogglerBtn() {
//   aside.classList.toggle("open");
//   navTogglerBtn.classList.toggle("open");
// }


// // Close aside when clicking outside
// document.addEventListener("click", (e) => {
//   const aside = document.querySelector(".aside");
//   const navToggler = document.querySelector(".nav-toggler");
  
//   if (!aside.contains(e.target) && !navToggler.contains(e.target)) {
//     if (aside.classList.contains("open")) {
//       aside.classList.remove("open");
//       navToggler.classList.remove("open");
//     }
//   }
// });
$(document).ready(function() {
    // Typing animation (unchanged as it's library code)
    var typed = new Typed(".typing", {
        strings: [
            "",
            "Web",
            "Web Designer",
            "Web Developer",
            "Content Creator",
        ],
        typeSpeed: 100,
        BackSpeed: 60,
        loop: true,
    });

    // Aside navigation
    const $nav = $(".nav"),
        $navList = $nav.find("li"),
        totalNavList = $navList.length,
        $allSection = $(".section"),
        totalSection = $allSection.length;

    $navList.find("a").on("click", function(e) {
        e.preventDefault();
        
        // Remove back-section class from all sections
        $allSection.removeClass("back-section");
        
        // Find active link and add back-section to corresponding section
        $navList.find("a.active").each(function(i) {
            $allSection.eq(i).addClass("back-section");
        });
        
        // Remove active class from all links
        $navList.find("a").removeClass("active");
        
        // Add active class to clicked link
        $(this).addClass("active");
        
        showSection(this);
        
        // Close aside on mobile after click
        if (window.innerWidth < 1200) {
            asideSectionTogglerBtn();
        }
    });

    function showSection(element) {
        // Remove active class from all sections
        $allSection.removeClass("active");
        
        // Add active class to target section
        const target = $(element).attr("href").split("#")[1];
        $("#" + target).addClass("active");
    }

    // Hire Me button handling
    $(".hire-me").on("click", function(e) {
        e.preventDefault();
        showSection(this);
        updateNav(this);
    });

    function updateNav(element) {
        $navList.find("a").removeClass("active");
        const target = $(element).attr("href").split("#")[1];
        
        $navList.find("a").each(function() {
            const hrefTarget = $(this).attr("href").split("#")[1];
            if (hrefTarget === target) {
                $(this).addClass("active");
            }
        });
    }

    // Nav toggler button
    const $navTogglerBtn = $(".nav-toggler"),
        $aside = $(".aside");
    
    $navTogglerBtn.on("click", asideSectionTogglerBtn);

    function asideSectionTogglerBtn() {
        $aside.toggleClass("open");
        $navTogglerBtn.toggleClass("open");
    }

    // Close aside when clicking outside
    $(document).on("click", function(e) {
        if (
            !$(e.target).closest($aside).length && 
            !$(e.target).closest($navTogglerBtn).length &&
            $aside.hasClass("open")
        ) {
            $aside.removeClass("open");
            $navTogglerBtn.removeClass("open");
        }
    });
});
