/* eslint-disable react/prop-types */
import React from 'react';
import { v4 as uuidv4 } from 'uuid';
import GridTableCell from '../GridTableCell/GridTableCell';
import { Props, useGridTable } from './useGridTable';

export default function GridTable({ raws, columns }: Props) {
  const { newSelectedAppointment } = useGridTable();

  return (
    <div className="scheduler__bodyTable">
      <table>
        <tbody>
          {raws.map((_: any, rowIndex: number) => (
            <tr key={uuidv4()}>
              {columns.map((day: any, cellIndex: number) => (
                <GridTableCell
                  selected={
                    // eslint-disable-next-line prettier/prettier
                    newSelectedAppointment?.raw === rowIndex
                    // eslint-disable-next-line prettier/prettier
                    && newSelectedAppointment?.cell === cellIndex
                  }
                  rawsQuantity={raws.length}
                  raw={rowIndex}
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
