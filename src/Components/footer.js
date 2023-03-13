class Footer extends HTMLElement {
    constructor() {
        super();
    }

    connectedCallback() {
        this.innerHTML = `
        <style>

            #footer {
            display: grid;
            font-size: 14px;
            line-height: 14px;
            }
            
            #footer-line {
            margin: 0;
            }
            
            #footer-left {
            padding: 20px;
            grid-column: 1;
            text-align: start;
            }
            
            #footer-right {
            padding: 20px;
            grid-column: 2;
            text-align: end;
            }

        </style>

        <footer>
            <hr id="footer-line">
            <div id="footer">
                <div id="footer-left">@ 2023 ADM 4379 Group 8</div>
                <div id="footer-right">Privacy Policy and Terms of Service not available</div>
            </div>
        </footer>
    `;
  }
}
customElements.define('footer-component', Footer);