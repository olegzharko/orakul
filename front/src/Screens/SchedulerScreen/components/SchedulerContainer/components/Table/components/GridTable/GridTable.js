/* eslint-disable react/prop-types */
import React from 'react';
import { v4 as uuidv4 } from 'uuid';
import GridTableCell from '../GridTableCell/GridTableCell';

export default function GridTable({ raws, columns }) {
  return (
    <div className="scheduler__bodyTable">
      <table>
        <tbody>
          {raws.map((_, rowIndex) => (
            <tr key={uuidv4()}>
              {columns.map((day, cellIndex) => (
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
