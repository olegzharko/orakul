/* eslint-disable react/prop-types */
import React from 'react';
import { v4 as uuidv4 } from 'uuid';
import GridTableCell from '../GridTableCell/GridTableCell';
import { Props, useGridTable } from './useGridTable';
import { checkIsSelected } from './utils';

export default function GridTable(props: Props) {
  const { newSelectedAppointment, roomsWithBackground } = useGridTable(props);

  return (
    <div className="scheduler__bodyTable">
      <table>
        <tbody>
          {props.rows.map((_: any, rowIndex: number) => (
            <tr key={uuidv4()}>
              {props.columns.map((day: any, cellIndex: number) => (
                <GridTableCell
                  selected={checkIsSelected(newSelectedAppointment, rowIndex, cellIndex)}
                  roomsWithBackground={roomsWithBackground}
                  rowsQuantity={props.rows.length}
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
