'use strict';

import React from 'react';
/**
* http://owlgraphic.com/owlcarousel/demos/one.html
* */
const OwlCarousel = React.createClass({

    getDefaultProps() {
        return {
            options : {},
            style : {},
        };
    },

    propTypes: {
        children : React.PropTypes.oneOfType([
            React.PropTypes.element,
            React.PropTypes.arrayOf(React.PropTypes.element.isRequired),
        ]).isRequired,

        style : React.PropTypes.object,
        id : React.PropTypes.string,
        options : React.PropTypes.shape({

            items : React.PropTypes.number,
            itemsCustom : React.PropTypes.arrayOf(React.PropTypes.arrayOf(React.PropTypes.number).isRequired),
            itemsDesktop : React.PropTypes.arrayOf(React.PropTypes.number.isRequired),
            itemsDesktopSmall : React.PropTypes.arrayOf(React.PropTypes.number.isRequired),
            itemsTablet : React.PropTypes.arrayOf(React.PropTypes.number.isRequired),
            itemsTabletSmall : React.PropTypes.arrayOf(React.PropTypes.number.isRequired),
            itemsMobile : React.PropTypes.arrayOf(React.PropTypes.number.isRequired),
            singleItem : React.PropTypes.bool,
            itemsScaleUp : React.PropTypes.bool,

            slideSpeed : React.PropTypes.number,
            paginationSpeed : React.PropTypes.number,
            rewindSpeed : React.PropTypes.number,

            autoPlay : React.PropTypes.oneOfType([
                React.PropTypes.bool,
                React.PropTypes.number,
            ]),
            stopOnHover : React.PropTypes.bool,

            navigation : React.PropTypes.bool,
            navigationText : React.PropTypes.arrayOf(React.PropTypes.string),
            rewindNav : React.PropTypes.bool,
            scrollPerPage : React.PropTypes.bool,

            pagination : React.PropTypes.bool,
            paginationNumbers : React.PropTypes.bool,

            responsive : React.PropTypes.bool,
            responsiveRefreshRate : React.PropTypes.number,
            responsiveBaseWidth : function(props, propName, componentName) {
                if (
                    props[propName] &&
                    !$(props[propName]).length
                ) {
                    return new Error('React-owl-carousel: the props `responsiveBaseWidth` needs jQuery selector.');
                }
            },

            baseClass : React.PropTypes.string,
            theme : React.PropTypes.string,

            lazyLoad : React.PropTypes.bool,
            lazyFollow : React.PropTypes.bool,
            lazyEffect : React.PropTypes.bool,

            autoHeight : React.PropTypes.bool,

            jsonPath : React.PropTypes.string,
            jsonSuccess : React.PropTypes.func,

            dragBeforeAnimFinish : React.PropTypes.bool,
            mouseDrag : React.PropTypes.bool,
            touchDrag : React.PropTypes.bool,

            addClassActive : React.PropTypes.bool,

            //build-in transitionStyle: 'fade', 'backSlide', 'goDown', 'scaleUp'
            transitionStyle : React.PropTypes.string,

            beforeUpdate : React.PropTypes.func,
            afterUpdate : React.PropTypes.func,
            beforeInit : React.PropTypes.func,
            afterInit : React.PropTypes.func,
            beforeMove : React.PropTypes.func,
            afterMove : React.PropTypes.func,
            afterAction : React.PropTypes.func,
            startDragging : React.PropTypes.func,
            afterLazyLoad: React.PropTypes.func,
        }),
    },

    componentDidMount() {
        $(React.findDOMNode(this)).owlCarousel(this.props.options);
    },

    componentWillReceiveProps(nextProps) {
        if (nextProps.update)
            $(React.findDOMNode(this)).data('owlCarousel').destroy();
    },

    componentDidUpdate(prevProps, prevState) {
        $(React.findDOMNode(this)).owlCarousel(this.props.options);
    },

    componentWillUnmount() {
        $(React.findDOMNode(this)).data('owlCarousel').destroy();
    },

    shouldComponentUpdate(nextProps, nextState) {
        return nextProps.update;
    },

    render() {

        this.props.options.touchDrag !== false
            ?   React.initializeTouchEvents(true)
            : React.initializeTouchEvents(false);

        let items = this.props.children.map( (child, i) => {
            return <div key={i} className='item'>{child}</div>
        });

        return (
            <div id={this.props.id} style={this.props.style}>
                {items}
            </div>
        );
    },

    next() {
        $(React.findDOMNode(this)).data('owlCarousel').next();
    },

    prev() {
        $(React.findDOMNode(this)).data('owlCarousel').prev();
    },

    // Go to x slide
    goTo(x) {
        $(React.findDOMNode(this)).data('owlCarousel').goTo(x);
    },

    // Go to x slide without slide animation
    jumpTo(x) {
        $(React.findDOMNode(this)).data('owlCarousel').jumpTo(x);
    },

    play() {
        $(React.findDOMNode(this)).data('owlCarousel').play();
    },

    stop() {
        $(React.findDOMNode(this)).data('owlCarousel').stop();
    },

});

module.exports = OwlCarousel;
