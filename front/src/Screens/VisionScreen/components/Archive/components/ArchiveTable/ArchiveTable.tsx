import React from 'react';
import { Link } from 'react-router-dom';
import { v4 as uuid } from 'uuid';

import { VisionNavigationLinks } from '../../../../enums';
import { ArchiveToolsTableHeader } from '../../types';

type ArchiveTableProps = {
  headers: ArchiveToolsTableHeader[],
  raws: any[][],
}

const ArchiveTable = ({ headers, raws }: ArchiveTableProps) => (
  <>
    <div className="vision-archive__table-header">
      {headers.map(({ alias, title }) => (
        <div style={{ width: `calc(100% / ${headers.length})` }} className="cell" key={alias}>{title}</div>
      ))}
    </div>
    <div className="vision-archive__table-body">
      {raws.map((raw, index) => {
        const id = raw[0][0];

        return (
          <Link to={`${VisionNavigationLinks.clientSide}/${id}`} className="line" key={id}>
            {raw.map((cell) => (
              <div style={{ width: `calc(100% / ${headers.length})` }} className="cell" key={uuid()}>
                {cell.map((val: any) => (
                  <span key={uuid()}>{val || ''}</span>
                ))}
              </div>
            ))}
          </Link>
        );
      })}
    </div>
  </>
);

export default ArchiveTable;
