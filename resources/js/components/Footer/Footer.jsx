import React from 'react';

import styled from './styled';

const Footer = () => (
  <styled.Footer>
    {`© ${new Date().getFullYear()} Alan Dours`}
  </styled.Footer>
);

export default Footer;
