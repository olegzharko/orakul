import React, { memo } from 'react';
import Slider from 'react-slick';
import './index.scss';

type Props = {
  images: string[];
};

const Carousel = ({ images }: Props) => {
  const settings = {
    dots: true,
    infinite: false,
    speed: 800,
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
  };

  return (
    <div className="carousel">
      <Slider {...settings}>
        {images.map((item: string) => (
          <img
            src={item}
            alt={item}
            key={item}
            className="officeMapMain__image"
          />
        ))}
      </Slider>
    </div>
  );
};

export default memo(Carousel);
