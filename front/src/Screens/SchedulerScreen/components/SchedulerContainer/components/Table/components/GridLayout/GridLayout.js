/* eslint-disable object-curly-newline */
/* eslint-disable camelcase */
/* eslint-disable react/prop-types */
import React, { useState, useEffect } from 'react';
import './GridLayout.scss';
import RGL, { WidthProvider } from 'react-grid-layout';
import $ from 'jquery';
import { v4 as uuidv4 } from 'uuid';

const ReactGridLayout = WidthProvider(RGL);

export default function GridLayout({ appointments, cols, handleDrag }) {
  const [dragAndDropWidth, setDragAndDropWidth] = useState(1200);

  useEffect(() => {
    setDragAndDropWidth($('.scheduler__appointments').width());
  }, []);

  const onDrag = (all, current) => {
    const currentApp = all.find((item) => item.i === current.i);
    handleDrag(currentApp);
  };

  if (!appointments) {
    return <span>Loading...</span>;
  }

  return (
    <ReactGridLayout
      className="scheduler__dragAndDrop"
      cols={cols}
      rowHeight={75}
      width={dragAndDropWidth}
      margin={[0, 0]}
      containerPadding={[0, 0]}
      verticalCompact={false}
      preventCollision
      layout={appointments}
      onDragStop={onDrag}
    >
      {appointments.map(({ i, title, color, short_info }) => (
        <div
          key={i}
          className="appointment"
          style={{ borderLeft: `4px solid ${color}` }}
        >
          <div className="appointment__title">{title}</div>
          <table className="appointment__table">
            <tbody>
              <tr>
                {Object.values(short_info).map((item) => (
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
