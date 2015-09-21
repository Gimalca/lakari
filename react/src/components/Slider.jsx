import React from 'react';


class Slider extends React.Component {

    constructor(props) {
        super(props);
    }

    componentDidMount() {

        var wrapper = this.refs.wrapper.getDOMNode();

        var leftNavigation = '<a class="left carousel-control" role="button"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span></a>';
        var rightNavigation = '<a class="right carousel-control" role="button"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a>';

        $(wrapper).owlCarousel({
            items : 4,
            navigation : true,
            itemsDesktopSmall :[979,2],
            itemsDesktop : [1199,2],
            slideSpeed : 900,
            pagination: true,
            paginationSpeed : 800,
            navigationText: [leftNavigation, rightNavigation],
            lazyLoad: true,
            autoPlay: this.props.autoPlay * 1000,
            stopOnHover: true,
            singleItem: this.props.single || false,
            transitionStyle: this.props.transition
        });
    }

    render() {

        var slides = React.Children.map(
            this.props.children, function (child, i) {
            return (<div key={i} className='item'>{child}</div>);
        });

        return (<div ref='wrapper'>{slides}</div>);
    }
}

export default Slider;

