import React, {Component} from 'react';
import './App.css';
import Slider from 'react-slick'

class App extends Component {
    constructor(props) {
        super(props);
        this.state = {
            imgs: []
        }
    }

    componentWillMount() {
        fetch("http://wlazlo.test/wp-json/trendone/v1/slides")
            .then(results => {
                return results.json();
            }).then(data => {
            this.setState({imgs: data});
        })
    }

    render() {
        let settings = {
            dots: true,
            slidesToShow: 1,
            adaptiveHeight: true,
        };
        return <div className="App container">
            <Slider {...settings} className="col-md-12">
                {this.state.imgs.map((item) => {
                    return <div key={item.postId} className="col-md-4 text-center">
                        <a href={item.buttonUrl}>
                            <img src={item.imgUrl} />
                        </a>
                    </div>
                })}
            </Slider>
        </div>;
    }
}

export default App;
