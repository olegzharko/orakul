/* eslint-disable react/prop-types */
import React from 'react';
import { v4 as uuidv4 } from 'uuid';
import GridTableCell from '../GridTableCell/GridTableCell';

export default function GridTable({ days, hours }) {
  const tableRows = new Array(hours.length * days.length).fill(1);

  return (
    <div className="scheduler__bodyTable">
      <table>
        <tbody>
          {tableRows.map((arr, rowIndex) => (
            <tr key={uuidv4()}>
              {days.map((item, cellIndex) => (
                <GridTableCell row={rowIndex} cell={cellIndex} key={uuidv4()} />
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
