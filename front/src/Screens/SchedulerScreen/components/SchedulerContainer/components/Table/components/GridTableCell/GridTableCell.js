/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
/* eslint-disable react/prop-types */
import React from 'react';
// import { v4 as uuidv4 } from 'uuid';

// redux

export default function GridLayoutCell({ rawsQuantity }) {
  // const handleClick = () => {
  //   const appointment = {
  //     i: uuidv4(),
  //     x: cell,
  //     y: row,
  //     w: 1,
  //     h: 1,
  //   };
  // };

  return (
    <td
      // onClick={handleClick}
      style={{ width: `calc(100% / ${rawsQuantity})` }}
    />
  );
}
