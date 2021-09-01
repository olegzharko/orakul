import React from 'react';
import { Link } from 'react-router-dom';

import { VisionNavigationLinks } from '../../../../enums';

import { archive_table_titles } from './config';

const ArchiveTable = () => (
  <>
    <div className="vision-archive__table-header">
      {archive_table_titles.map((title) => (
        <span key={title}>{title}</span>
      ))}
    </div>
    <div className="vision-archive__table-body">
      <Link to={`${VisionNavigationLinks.clientSide}/2`} className="line" />
      <Link to={`${VisionNavigationLinks.clientSide}/2`} className="line" />
      <Link to={`${VisionNavigationLinks.clientSide}/2`} className="line" />
      <Link to={`${VisionNavigationLinks.clientSide}/2`} className="line" />
      <Link to={`${VisionNavigationLinks.clientSide}/2`} className="line" />
    </div>
  </>
);

export default ArchiveTable;
