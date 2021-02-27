/* eslint-disable react/prop-types */
import React from 'react';
import { v4 as uuidv4 } from 'uuid';
import GridTableCell from '../GridTableCell/GridTableCell';

export default function GridTable({ raws, cells }) {
  return (
    <div className="scheduler__bodyTable">
      <table>
        <tbody>
          {cells.map((hour, rowIndex) => (
            <tr key={uuidv4()}>
              {raws.map((day, cellIndex) => (
                <GridTableCell
                  rawsQuantity={raws.length}
                  row={rowIndex}
                  cell={cellIndex}
                  key={uuidv4()}
                />
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
