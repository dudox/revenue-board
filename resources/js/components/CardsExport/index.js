import React, { Component } from "react";
import ReactDOM from "react-dom";
import './style.css';

export default class CardsExport extends Component {
  constructor(props) {
    super(props);
    this.state = {
      amount: 0,
      denomination: "",
      batch: "",
      denominations: [],
      screen: this.showLoader(),
      progress: 0,
      total:0,
      percent: 0,
    };
  }

  showLoader() {
    //   return loader
    return (
        <div>
            <div className="loader"></div>
        </div>
    );
  }


  render() {
    //   Display modal while generating
    return (
      <div className=''>
          {this.state.screen}
      </div>
    );
  }
}

if (document.getElementById("exportcards")) {
  const element = document.getElementById("exportcards");

  // create new props object with element's data-attributes
  // result: {tsId: "1241"}
  const props = Object.assign({}, element.dataset);

  ReactDOM.render(<CardsExport {...props} />, element);
}
