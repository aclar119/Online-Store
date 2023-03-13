class Navbar extends HTMLElement {
    constructor() {
        super();
    }

    connectedCallback() {
        let styling = `
        <style>
          .navbar {
              display: grid;
              background-color: #213536;
          }
          
          #navbar-left {
              display: flex;
              grid-column: 1;
          }
          
          #navbar-right {
              display: flex;
              grid-column: 2;
              justify-content: end;
          }
          
          #logo {
              display: flex;
              height: 50px;
              padding-left: 16px;
              padding-right: 16px;
              align-items: center;
              justify-items: center;
          }
          
          #logo:hover{
              cursor: pointer;
              opacity: 60%;
          }
          
          .navbar a {
              z-index: 1;
              display: block;
              color: #F8F8F8;
              text-align: center;
              padding-top: 14px;
              padding-bottom: 14px;
              padding-left: 16px;
              padding-right: 16px;
              text-decoration: none;
              font-size: 18px;
              line-height: 22px;
          }
          
          .navbar a:hover {
              opacity: 60%;
              border-bottom: 3px solid #F8F8F8;
              padding-bottom: 11px;
          }

          .selected a {
              border-bottom: 3px solid #F8F8F8;
              padding-bottom: 11px;
          }

          #cart.selected {
            border-bottom: 3px solid #F8F8F8;
            padding-bottom: 0px;
          }

          #account.selected {
            border-bottom: 3px solid #F8F8F8;
            padding-bottom: 0px;
          }
          
          #search-bar {
              display: flex;
              align-items: center;
              justify-content: end;
              padding-right: 16px;
          }
          
          #search-bar div {
              display: flex;
              flex-direction: row;
              flex-wrap: nowrap;
              justify-content: space-between;
              height:fit-content;
              border-bottom: 2px solid #F8F8F8;
              padding-bottom: 0;
              width: 80%;
          }
          
          #search-bar button {
              height: auto;
              border: none;
              background-color: #00000000;
          }
          
          #search-bar img {
              height: 20px;
          }
          
          #search-input {
              opacity: 100%;
              font-size: 18px;
              border: none;
              text-align: end;
              color: #F8F8F8;
              background-color: #00000000;
              width: 100%;
          }
          
          #search-input:focus {
              border: none;
              background-color: #00000000;
              outline: none;
          }
          
          #search-input::placeholder {
              color: #F8F8F8;
              opacity: 60%;
          }
          
          #cart {
              display: flex;
              height: calc(100% - 3px);
              padding-left: 16px;
              padding-right: 16px;
              padding-bottom: 3px;
              align-items: center;
              justify-items: center;
          }
          
          #cart:hover {
              cursor: pointer;
              opacity: 60%;
              border-bottom: 3px solid #F8F8F8;
              padding-bottom: 0px;
          }
  
          #account {
              display: flex;
              height: calc(100% - 3px);
              padding-left: 16px;
              padding-right: 16px;
              padding-bottom: 3px;
              align-items: center;
              justify-items: center;
            }
          
            #account:hover {
              cursor: pointer;
              opacity: 60%;
              border-bottom: 3px solid #F8F8F8;
              padding-bottom: 0px;
            }
        </style>`;

        let structure = `
        <div class="navbar">
                <div id="navbar-left">
                    <div id="logo" onclick="window.location.href='../Home/Home.php';"><img src="../../resources/Icons/Logo.png" height="32" ></div>
                    <div><a href="../BrowseProducts/BrowseProducts.php">Store</a></div>
                    <div><a href="../AboutUs/AboutUs.php">About Us</a></div>
                </div>

                <div id="navbar-right">
                    <form id="search-bar" action="../BrowseProducts/BrowseProducts.php">
                        <div>
                            <button><img src="../../resources/Icons/Search.png"></button>
                            <input id="search-input" type="text" placeholder="Search" name="search" autocomplete="off">
                        </div>
                    </form>
                    <div id="cart" onclick="window.location.href='../Cart/Cart.php';"><img src="../../resources/Icons/Cart.png" height="32" ></div>
                    <div id="account" onclick="window.location.href='../Account/Login.php';"><img src="../../resources/Icons/Account.png" height="32" ></div>
                </div>
            </div>
        `;

        if (this.getAttribute("page") == "Store") {
            structure = structure.replace(`<div><a href="../BrowseProducts/BrowseProducts.php">`, `<div class="selected"><a href="../BrowseProducts/BrowseProducts.php">`);
        } else if (this.getAttribute("page") == "About Us") {
            structure = structure.replace(`<div><a href="../AboutUs/AboutUs.php">`, `<div class="selected"><a href="../AboutUs/AboutUs.php">`);
        } else if (this.getAttribute("page") == "Cart") {
            structure = structure.replace(`div id="cart"`, `div class="selected" id="cart"`);
        } else if (this.getAttribute("page") == "Account") {
            structure = structure.replace(`div id="account"`, `div class="selected" id="account"`);
        }

        this.innerHTML = styling + structure;
  }
}

customElements.define('navbar-component', Navbar);