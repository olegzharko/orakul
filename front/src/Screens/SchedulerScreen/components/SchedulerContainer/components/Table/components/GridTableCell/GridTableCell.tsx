/* eslint-disable react/destructuring-assignment */
/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-noninteractive-element-interactions */
import React from 'react';
import { Props, useGridTableCell } from './useGridTableCell';

const GridLayoutCell = (props: Props) => {
  const { backGroundColor, onClick } = useGridTableCell(props);

  return (
    <td
      onClick={onClick}
      style={{
        width: `calc(100% / ${props.rowsQuantity})`,
        backgroundColor: props.selected ? '#E5E5E5' : backGroundColor,
      }}
    />
  );
};

export default GridLayoutCell;
