import React, { Component } from "react";
import ReactDOM from "react-dom";
import './style.css';

export default class CardsGenerator extends Component {
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
      exportButton: this.getExportButton(),
      message: '',
    };
  }

  showLoader() {
    //   return loader
    return (
        <div>
            <div className="loader"></div>
            <p className="text-center"> Loading... </p>
        </div>
    );
  }

  showExportLoader() {
    //   return loader
    return (
        <div>
            <div className="loader"></div>
            <p className="text-center"> Exporting... </p>
        </div>
    );
  }

  showProgress() {
    // Show progress if downloading
    return (
        <div>
            <div className="loader"></div>
            <p className="text-center"> Generating {`${this.state.progress}/${this.state.total}`} ({this.state.percent}%)</p>
        </div>
    );
  }

    setupStream() {
        // Not a real URL, just using for demo purposes
        let es = new EventSource(`${this.props.url}/api/denominations/ongoing/${this.props.batch}`);

        es.addEventListener('message', event => {
            let data = JSON.parse(event.data);
            // this.stockData = data.stockData;
            console.log(data);
            this.setState({
                progress: data.progress,
                total: data.total,
                percent: data.percent,
                screen: this.showProgress(),
            })

            if(data.ended === true) {
                this.setState({
                    progress: data.progress,
                    total: data.total,
                    percent: data.percent,
                    screen: this.getForm(),
                })
                es.close();
            }
        }, false);
        // es.close();
        es.addEventListener('error', event => {
            this.setState({screen: this.getForm()});
            if (event.readyState == EventSource.CLOSED) {
                console.log('Event was closed');
            }
        }, false);
    }

  prepare() {
    // check if download is ongoing and return progress then set interval

    this.setState({screen: this.showProgress()});

    // Else show form

  }


  componentDidMount() {
    this.getDenominations(this.props.batch);
    // this.prepare();
    this.setupStream()
  }

  getDenominations(url, body = {}, method = 'GET') {
    // const user = {
    //     first_name: 'John',
    //     last_name: 'Lilly',
    //     job_title: 'Software Engineer'
    // };
    let options = {
        method: method,
        body: JSON.stringify(body),
        headers: {
            'Content-Type': 'application/json'
        }
    }


    if(method === 'GET') {
        options = {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            }
        }
    }

    fetch(`${this.props.url}/api/denominations/${url}`, options)
        .then(res => res.json())
        .then(res => {
           let a = res.success.map((r, e) =>
                <option key={e} value={r.id}> {r.cost} | {r.duration.name} | {r.identifier} </option>
            );
            this.setState({
                denominations: a,
            })
        });
  }

  export() {
    this.setState({
        screen: this.showExportLoader(),
    })
    let options = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    }


    fetch(`${this.props.url}/api/denominations/export/${this.props.batch}`, options)
    .then(res => res.json())
    .then(res => {
        this.setState({
            screen: this.getForm(),
            message: `<p class="text-success"> Cards exported successfully</p>`,
        })
    })
    .catch(er => {
        this.setState({
            screen: this.getForm(),
            message: `<p class="text-danger"> Cards export failed </p>`,
        })
    });
  }

  generate() {
    // Not a real URL, just using for demo purposes

    let es = new EventSource(`${this.props.url}/api/denominations/generate/${this.state.denomination}/${this.state.amount}/${this.props.batch}`);

    es.addEventListener('message', event => {
        let data = JSON.parse(event.data);
        // this.stockData = data.stockData;
        console.log(data);
        this.setState({
            progress: data.progress,
            total: data.total,
            percent: data.percent,
            screen: this.showProgress(),
        })

        if(data.ended === true) {
            this.setState({
                progress: data.progress,
                total: data.total,
                percent: data.percent,
                screen: this.getForm(),
            })
            es.close();
            window.location.reload();
        }

    }, false);
    // es.removeEventListener()
    es.addEventListener('error', event => {
        this.setState({screen: this.getForm()});
        if (event.readyState == EventSource.CLOSED) {
            console.log('Event was closed');
        }
    }, false);
  }

  getExportButton() {
    return (
        <div className="text-center">
            <button onClick={() => this.export()} className="btn btn-primary my-4">Export Batch Cards</button>
        </div>
    );
  }
  getForm() {
      return (
        <div>
            {this.getExportButton()}
            <h4 className="text-center"> Generate Cards</h4>
            <div className="col-md-5 text-center">
                <div className="form-group mb-3">
                <div className="input-group">
                    <input className="form-control" onChange={(e) => this.setState({amount: e.target.value})} style={{width: 200}} placeholder="Enter Card quantity" type="number" name="cost" required />
                </div>
                </div>
                <div className="form-group mb-3" style={{textAlign: 'center'}}>
                <div className="input-group" style={{display: 'inline-block'}}>
                    <select className="form-control" onChange={(e) => this.setState({denomination: e.target.value})} style={{width: 200}} required>
                        <option value="">
                            Select Denomination
                        </option>
                        {this.state.denominations}
                    </select>
                </div>
                </div>
                <div className="text-center" style={{textAlign: 'center'}}>
                <button onClick={() => this.generate()} className="btn btn-primary my-2" style={{display: 'inline-block', width: 200}}>Generate Cards</button>
                </div>
            </div>
        </div>
      );
    }

    getModal() {

    }

  render() {
    //   Display modal while generating
    return (
      <div className='text-center'>
          <span dangerouslySetInnerHTML={{__html: this.state.message}}>

          </span>
          {this.state.screen}
      </div>
    );
  }
}

if (document.getElementById("cardsgenerator")) {
  const element = document.getElementById("cardsgenerator");

  // create new props object with element's data-attributes
  // result: {tsId: "1241"}
  const props = Object.assign({}, element.dataset);

  ReactDOM.render(<CardsGenerator {...props} />, element);
}
