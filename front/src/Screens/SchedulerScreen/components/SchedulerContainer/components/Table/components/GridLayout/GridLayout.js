/* eslint-disable jsx-a11y/no-static-element-interactions */
/* eslint-disable react/prop-types */
import React, { useState, useEffect, useCallback } from 'react';
import './GridLayout.scss';
import RGL, { WidthProvider } from 'react-grid-layout';
import $ from 'jquery';
import { v4 as uuidv4 } from 'uuid';
import { useSelector } from 'react-redux';
import ReactHtmlParser from 'react-html-parser';
import { State } from '../../../../../../../../store/types';

const ReactGridLayout = WidthProvider(RGL);

export default function GridLayout({
  appointments,
  cols,
  handleDrag,
  handleClick,
}) {
  const [dragAndDropWidth, setDragAndDropWidth] = useState(1200);
  const { schedulerLock } = useSelector((state) => state.scheduler);
  const oldSelectedAppointment = useSelector(
    (state) => state.scheduler.oldSelectedAppointment
  );

  useEffect(() => {
    setDragAndDropWidth($('.scheduler__appointments').width());
  }, []);

  const onDrag = (all, current) => {
    const currentApp = all.find((item) => item.i === current.i);
    handleDrag(currentApp);
    handleClick(currentApp);
  };

  const isSelected = useCallback((raw, cell) => oldSelectedAppointment.raw === raw
    && oldSelectedAppointment.cell === cell, [oldSelectedAppointment]);

  if (!appointments) {
    return <span>Loading...</span>;
  }

  return (
    <ReactGridLayout
      className="scheduler__dragAndDrop"
      cols={cols}
      rowHeight={80}
      width={dragAndDropWidth}
      margin={[0, 0]}
      containerPadding={[0, 0]}
      verticalCompact={false}
      preventCollision
      layout={appointments}
      onDragStop={onDrag}
      isDraggable={!schedulerLock}
    >
      {appointments.map((appointment) => (
        <div
          key={appointment.i}
          className="appointment"
          style={{
            borderLeft: `4px solid ${appointment.color}`,
            backgroundColor: isSelected(appointment.y, appointment.x) ? appointment.color : ''
          }}
          onClickCapture={() => handleClick(appointment)}
        >
          <div className="appointment__title">{ReactHtmlParser(appointment.title)}</div>
          <table className="appointment__table">
            <tbody>
              <tr>
                {Object.values(appointment.short_info).map((item) => (
                  <td key={uuidv4()}>{item}</td>
                ))}
              </tr>
            </tbody>
          </table>
        </div>
      ))}
    </ReactGridLayout>
  );
}
